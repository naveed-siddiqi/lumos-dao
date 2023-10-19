#![cfg(test)]
extern crate std;

use super::*;
use soroban_sdk::testutils::{Address as _, AuthorizedFunction, AuthorizedInvocation, Ledger};
use soroban_sdk::{symbol_short, token, vec, Address, Env, IntoVal, String};
use token::Client as TokenClient;
use token::StellarAssetClient as TokenAdminClient;
use crate::contract::{DaoContract, DaoContractClient};
use crate::storage::{DaoMeta};


fn create_token_contract<'a>(e: &Env, admin: &Address) -> (TokenClient<'a>, TokenAdminClient<'a>) {
    let contract_address = e.register_stellar_asset_contract(admin.clone());
    (
        TokenClient::new(e, &contract_address),
        TokenAdminClient::new(e, &contract_address),
    )
}

fn create_dao_test_contract<'a>(e: &Env) -> DaoContractClient<'a> {
    DaoContractClient::new(e, &e.register_contract(None, DaoContract {}))
}

struct DaoTest<'a> {
    env: Env,
    deposit_address: Address,
    token_admin: Address,
    token: TokenClient<'a>,
    contract: DaoContractClient<'a>,
}

impl<'a> DaoTest<'a> {
    fn setup() -> Self {
        let env = Env::default();
        env.mock_all_auths();

        env.ledger().with_mut(|li| {
            li.timestamp = 12345;
        });

        let deposit_address = Address::random(&env);

        let claim_addresses = [
            Address::random(&env),
            Address::random(&env),
            Address::random(&env),
        ];

        let token_admin = Address::random(&env);

        let (token, token_admin_client) = create_token_contract(&env, &token_admin);
        token_admin_client.mint(&deposit_address, &1000);

        let contract = create_dao_test_contract(&env);
        DaoTest {
            env,
            deposit_address,
            token_admin,
            token,
            contract,
            
        }
    }
}


#[test]
fn test_create_dao() {
    let test = DaoTest::setup();
    let created: u64 = 123456789000;
    test.contract.create(
        &test.token_admin,
        &test.token.address,
        &"DAO".into_val(&test.env),
        &"Friendly Dao".into_val(&test.env),
        &"Friendly Dao".into_val(&test.env),
        &created
    );
    let dao: DaoMeta = test.contract.get_dao(&test.token.address);
    assert_eq!(dao.name, "DAO".into_val(&test.env));
}

#[test]
fn test_create_proposal() {
    let test = DaoTest::setup();
    //first create dao
    let created: u64 = 123456789000;
    let end: u64 = created + 70000;
    test.contract.create(
        &test.token_admin,
        &test.token.address,
        &"DAO".into_val(&test.env),
        &"Friendly Dao".into_val(&test.env),
        &"Friendly Dao".into_val(&test.env),
        &created
    );
    test.contract.create_proposal(
        &test.deposit_address,
        &test.token.address,
        &"My First Proposal".into_val(&test.env), 
        &"Lets begin!".into_val(&test.env),
        &created,
        &end
    );
}

#[test]
fn vote_proposal() {
    let test = DaoTest::setup();
    //first create dao
    let created: u64 = 123456789000;
    let end: u64 = created + 70000;
    test.contract.create(
        &test.token_admin,
        &test.token.address,
        &"DAO".into_val(&test.env),
        &"Friendly Dao".into_val(&test.env),
        &"Friendly Dao".into_val(&test.env),
        &created,
    );
    let id: u32 = test.contract.create_proposal(
        &test.deposit_address,
        &test.token.address,
        &"My First Proposal".into_val(&test.env), 
        &"Lets begin!".into_val(&test.env),
        &created,
        &end
    );

    assert_eq!(test.contract.vote_on_proposal(
        &id,
        &test.deposit_address
    ), symbol_short!("voted"))
    
}

#[test]
fn execute_proposal() {
    let test = DaoTest::setup();
    let created: u64 = 123456789000;
    let end: u64 = created + 70000;
    test.contract.create(
        &test.token_admin,
        &test.token.address,
        &"DAO".into_val(&test.env),
        &"Friendly Dao".into_val(&test.env),
        &"Friendly Dao".into_val(&test.env),
        &created,
    );
    let id: u32 = test.contract.create_proposal(
        &test.deposit_address,
        &test.token.address,
        &"My First Proposal".into_val(&test.env), 
        &"Lets begin!".into_val(&test.env),
        &created,
        &end
    );

    test.contract.vote_on_proposal(
        &id,
        &test.deposit_address
    );

    assert_eq!(test.contract.execute_proposal(
        &id,
        &test.token_admin,
    ), symbol_short!("done"))
    
}
//soroban contract deploy --wasm target/wasm32-unknown-unknown/release/lumos_dao_contract.wasm --source guudc --network testnet