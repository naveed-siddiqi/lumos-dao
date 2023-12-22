#![cfg(test)]
extern crate std;

use super::*;
use soroban_sdk::testutils::{Address as _, AuthorizedFunction, AuthorizedInvocation, Ledger};
use soroban_sdk::{symbol_short, token, vec, log, Address, Env, IntoVal, String};
use token::Client as TokenClient;
use token::StellarAssetClient as TokenAdminClient;
use crate::contract::{DaoContract, DaoContractClient};
use crate::storage::{DaoMeta, DaoMetadata, Proposal};


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

        let deposit_address = Address::generate(&env);

        let claim_addresses = [
            Address::generate(&env),
            Address::generate(&env),
            Address::generate(&env),
        ];

        let token_admin = Address::generate(&env);

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
    let ttest = DaoTest::setup();
    let created: u64 = 123456789000;
    let _adr: Address = ttest.token.address.clone();
    let _addr: Address = test.token.address.clone();
    
    test.contract.create(
        &test.token_admin,
        &test.token.address,
        &"DAO".into_val(&test.env),
        &"Friendly Dao".into_val(&test.env),
        &"Friendly Dao".into_val(&test.env),
        &created
    );
    let dao: DaoMeta = test.contract.get_dao(&test.token.address);
    
    let res: bool = test.contract.create(
        &test.deposit_address,
        &ttest.token_admin,
        &"DAOs".into_val(&test.env),
        &"Friendly Dao".into_val(&test.env),
        &"Friendly Dao".into_val(&test.env),
        &created
    );
    let daos: DaoMeta = test.contract.get_dao(&test.token_admin);
    let dao: DaoMeta = test.contract.get_dao(&test.token.address);
    
    assert_eq!(daos.name, "DAOs".into_val(&test.env));
    assert_eq!(dao.name, "DAO".into_val(&test.env));
}

#[test]
fn test_create_proposal() {
    let test = DaoTest::setup();
 
    //first create dao
    let created: u64 = 123456789000;
    let end: u64 = created + 70000;
    let creates: u64 = 123456789000;
    test.contract.create(
        &test.token_admin,
        &test.token.address,
        &"DAO".into_val(&test.env),
        &"Friendly Dao".into_val(&test.env),
        &"Friendly Dao".into_val(&test.env),
        &created
    );
    let id: u64 = test.contract.create_proposal(
        &test.deposit_address,
        &test.token.address,
        &"My First Proposal".into_val(&test.env), 
        &"Lets begin!".into_val(&test.env),
        &creates,
        &"Links1, Links2".into_val(&test.env)
    );
    let _id: u64 = test.contract.create_proposal(
        &test.token_admin,
        &test.token.address,
        &"My Second Proposal".into_val(&test.env), 
        &"Lets begin again!".into_val(&test.env),
        &creates,
        &"Links1, Links2".into_val(&test.env)
    );

    let prop: Proposal = test.contract.get_proposal(&id);
    assert_eq!(prop.name, "My First Proposal".into_val(&test.env));

    let props: Proposal = test.contract.get_proposal(&_id);
    assert_eq!(props.name, "My Second Proposal".into_val(&test.env));
}

#[test]
fn vote_proposal() {
    let test = DaoTest::setup();
    //first create dao
    let created: u64 = 123456789000;
    let end: u64 = created + 70000;
    let creates: u64 = 123456789000;
    let vote_type: u64 = 1;
    let voting_power: u64 = 1;
    test.contract.create(
        &test.token_admin,
        &test.token.address,
        &"DAO".into_val(&test.env),
        &"Friendly Dao".into_val(&test.env),
        &"Friendly Dao".into_val(&test.env),
        &created,
    );
    let id: u64 = test.contract.create_proposal(
        &test.deposit_address,
        &test.token.address,
        &"My First Proposal".into_val(&test.env), 
        &"Lets begin!".into_val(&test.env),
        &creates,
        &"Links1, Links2".into_val(&test.env)
    );

    assert_eq!(test.contract.vote_on_proposal(
        &id,
        &test.token_admin,
        &vote_type,
        &voting_power
    ), symbol_short!("voted"));
    
    assert_eq!(test.contract.get_vote_type_proposal(
        &id,
        &test.token_admin,
    ), vote_type);
}

// #[test]
// fn execute_proposal() {
//     let test = DaoTest::setup();
//     let created: u64 = 123456789000;
//     let end: u64 = created + 70000;
//     let creates: u64 = 123456789000;
//     test.contract.create(
//         &test.token_admin,
//         &test.token.address,
//         &"DAO".into_val(&test.env),
//         &"Friendly Dao".into_val(&test.env),
//         &"Friendly Dao".into_val(&test.env),
//         &created,
//     );
//     let id: u64 = test.contract.create_proposal(
//         &test.deposit_address,
//         &test.token.address,
//         &"My First Proposal".into_val(&test.env), 
//         &"Lets begin!".into_val(&test.env),
//         &creates,
//         &"Links1, Links2".into_val(&test.env)
//     );

//     let prop: Proposal = test.contract.get_proposal(
//         &id
//     ); 

//     test.contract.vote_on_proposal(
//         &id,
//         &test.deposit_address
//     );

//     assert_eq!(test.contract.execute_proposal(
//         &id,
//         &test.token_admin,
//     ), symbol_short!("done"))
    
// }
//soroban contract deploy --wasm target/wasm32-unknown-unknown/release/lumos_dao_contract.wasm --source guudc --network testnet