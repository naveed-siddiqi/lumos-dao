#![cfg(test)]
extern crate std;

use super::*;
use soroban_sdk::testutils::{Address as _, AuthorizedFunction, AuthorizedInvocation, Ledger};
use soroban_sdk::{symbol_short, token, vec, log, Address, Env, IntoVal, String};
use token::Client as TokenClient;
use token::StellarAssetClient as TokenAdminClient;
use crate::contract::{DaoContract, DaoContractClient};
use crate::storage::{DaoMeta, Proposal};


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
        token_admin_client.mint(&deposit_address, &10000);
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
    );
    let dao: DaoMeta = test.contract.get_dao(&test.token.address);
    assert_eq!(dao.token, test.token.address);
}

#[test]
fn test_create_proposal() {
    let test = DaoTest::setup();
 
    //first create dao
    let created: u64 = 123456789000;
    let end: u64 = created + 70000;
    let creates: u64 = 123456789000;
    let budget: i128 = 30000;
    test.contract.create(
        &test.token_admin,
        &test.token.address,
     );
    let id: u64 = test.contract.create_proposal(
        &test.deposit_address,
        &test.token.address,
    );
    
    assert_eq!(test.contract.add_delegate(
        &test.token.address,
        &test.deposit_address,
        &test.token_admin,
    ), symbol_short!("true"));
    
    assert_eq!(test.contract.ban_member(
        &test.token.address,
        &test.token_admin,
    ), symbol_short!("true"));

    assert_eq!(test.contract.get_ban(
        &test.token.address,
        &test.token_admin,
    ), true);

    assert_eq!(test.contract.un_ban_member(
        &test.token.address,
        &test.token_admin,
    ), symbol_short!("true"));
    
    assert_eq!(test.contract.get_ban(
        &test.token.address,
        &test.token_admin,
    ), false);

    test.contract.get_delegatee(
        &test.token.address,
        &test.deposit_address,
    );

    let prop: Proposal = test.contract.get_proposal(&id);
    assert_eq!(prop.creator, test.deposit_address);

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
    let budget: i128 = 300;
    test.contract.create(
        &test.token_admin,
        &test.token.address,
    );
    let id: u64 = test.contract.create_proposal(
        &test.deposit_address,
        &test.token.address,
    );
    assert_eq!(test.contract.execute_proposal(
        &id,
        &test.token_admin,
        &1,
        &2
    ), symbol_short!("done"));

    assert_eq!(test.contract.vote_on_proposal(
        &id,
        &test.token_admin,
        &vote_type,
        &voting_power,
    ), symbol_short!("voted"));
    
    assert_eq!(test.contract.get_vote_type_proposal(
        &id,
        &test.token_admin,
    ), vote_type);
}


#[test]
fn execute_proposal() {
    let test = DaoTest::setup();
    //first create dao
    let created: u64 = 123456789000;
    let end: u64 = created + 70000;
    let creates: u64 = 123456789000;
    let vote_type: u64 = 1;
    let voting_power: u64 = 1;
    let budget: i128 = 30;
    let status: u64 = 0;
    test.contract.create(
        &test.token_admin,
        &test.token.address,
    );
    let id: u64 = test.contract.create_proposal(
        &test.deposit_address,
        &test.token.address,
    );

    assert_eq!(test.contract.execute_proposal(
        &id,
        &test.token_admin,
        &1,
        &2
    ), symbol_short!("done"));

    test.contract.vote_on_proposal(
        &id,
        &test.token_admin,
        &vote_type,
        &voting_power,
    );
   
    assert_eq!(test.contract.add_admin(
        &test.token.address,
        &test.token_admin,
        &test.deposit_address,
    ), symbol_short!("true"));

    assert_eq!(test.contract.add_admin(
        &test.token.address,
        &test.token_admin,
        &test.token_admin,
    ), symbol_short!("true"));

    let dao: DaoMeta = test.contract.get_dao(&test.token.address);
    assert_eq!(dao.admins.len(), 2);

    assert_eq!(test.contract.remove_admin(
        &test.token.address,
        &test.token_admin,
        &test.deposit_address,
    ), symbol_short!("true"));

    assert_eq!(test.contract.execute_proposal(
        &id,
        &test.token_admin,
        &status,
        &3
    ), symbol_short!("invalid"));
  
}
//soroban contract deploy --wasm target/wasm32-unknown-unknown/release/lumos_dao_contract.wasm --source guudc --network testnet