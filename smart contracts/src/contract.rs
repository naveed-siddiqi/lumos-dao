/**Lumst DAO Contract
*/

//CREATES
use soroban_sdk::{contract, contractimpl, token, symbol_short, vec, Symbol, Address, Env, Vec, String};
use crate::storage::{MIN_DAO_TOKEN_BALANCE, MIN_VOTES_AMOUNT, VoterKey, Proposal, DAO, ProposalId, DaoMetadata, DaoMeta};


#[contract]
pub struct DaoContract;

#[contractimpl]
impl DaoContract {
     
    //to create a new DAO with owner address, token address and ame
    pub fn create(env: Env, owner: Address, _token: Address, name: String, description:String, url: String, created: u64) -> bool{
        bump_lifetime(&env);
        if !is_dao(&env, &_token) {
            //create a dao
            let token = _token.clone();
            let _owner: Address = owner.clone();
            let members: Vec<Address> = vec![&env, _owner];
            let proposals_list: Vec<u32> = vec![&env];
            const active_proposals: u32 = 0;
            const proposals: u32 = 0;
            env.storage().persistent().set(
                &_token,
                &DAO {
                    owner,
                    token,
                    name,
                    description,
                    url,
                    members,
                    active_proposals,
                    proposals,
                    proposals_list,
                    created
                },
            );
            modify_metadata(&env, &"dao", _token.clone());
            modify_metadata(&env, &"daos", _token.clone());
            return true
        }   
        else {
            return false
        } 
    }

    //to create a proposal
    pub fn create_proposal(env: Env, creator:Address, _token: Address, name:String, description: String, start:u64, end: u64) -> u32 {
        //check if the dao exists
        bump_lifetime(&env);
        if is_dao(&env, &_token) && (end > start) {
            let mut _dao: DAO = env.storage().persistent().get(&_token).unwrap();
            //if _dao.owner == owner {
            let creator_balance: i128 = token::Client::new(&env, &_dao.token).balance(&creator);
            if creator_balance > MIN_DAO_TOKEN_BALANCE {
                let dao = _token.clone();
                let votes = 0;
                let executed = false;
                let _prop: ProposalId = get_id(&env);
                let voters: Vec<Address> = vec![&env];
                let _creator = creator.clone();
                env.storage().persistent().set(
                    &_prop.id,
                    &Proposal {
                        name,
                        description,
                        creator,
                        votes,
                        voters,
                        dao,
                        executed,
                        start,
                        end,
                    },
                );
                //increment the active proposals
                _dao.active_proposals = _dao.active_proposals + 1;
                //increment the total proposals
                _dao.proposals = _dao.proposals + 1;
                _dao.proposals_list.push_back(_prop.id.clone());
                env.storage().persistent().set(&_token, &_dao);
                //increase members if the creator is new
                if add_member_dao(&env, _token.clone(), _creator) == true {
                    modify_metadata(&env, &"user", _token.clone());
                }
                modify_metadata(&env, &"proposal", _token.clone());
                return _prop.id;
            }
            else {
                return 0
            }
        }
        else {
            return 0
        }
    }

    //to vote on a proposal
    //voter can only vote once
    pub fn vote_on_proposal(env: Env, _proposal_id:u32, voter: Address) -> Symbol {
        //check if the proposal exists
        bump_lifetime(&env);
        if env.storage().persistent().has(&_proposal_id) {
            //check if proposal is still going on
            let mut prop: Proposal = env.storage().persistent().get(&_proposal_id).unwrap();
            if prop.executed == false {
                //check if user has enough of the DAO Token to vote
                let mut dao: DAO = env.storage().persistent().get(&prop.dao).unwrap();
                let voter_balance: i128 = token::Client::new(&env, &dao.token).balance(&voter);
                if voter_balance > MIN_DAO_TOKEN_BALANCE {
                    //can vote
                    let id = _proposal_id.clone();
                    if !prop.voters.contains(&voter) {
                        //has not voted
                        prop.votes = prop.votes + 1;
                        prop.voters.push_back(voter.clone());
                        //save back the proposal
                        let flg: bool = true;
                        env.storage().persistent().set(
                            &_proposal_id,
                            &prop
                        );
                        //save back this member as part of the dao members
                        if add_member_dao(&env, dao.token.clone(), voter) == true {
                            modify_metadata(&env, &"user", dao.token.clone());
                        }
                        modify_metadata(&env, &"votes", dao.token.clone());
                        return symbol_short!("voted");
                    }
                    else {
                        return symbol_short!("hasvoted");
                    }
                }
                else {
                    return symbol_short!("lowbal");
                }
            }
            else {
                return symbol_short!("inactive");
            }
        }
        else {
            return symbol_short!("dontexist"); //Proposal dont exists
        }
    }

    //execute a proposal
    pub fn execute_proposal(env: Env, _proposal_id:u32, owner: Address) -> Symbol {
        //check if the proposal exists
        bump_lifetime(&env);
        if env.storage().persistent().has(&_proposal_id) {
            //check if proposal is still going on
            let mut prop: Proposal = env.storage().persistent().get(&_proposal_id).unwrap();
            let mut dao: DAO = env.storage().persistent().get(&prop.dao).unwrap();
            if dao.owner == owner {
                //can execute
                if prop.votes >= MIN_VOTES_AMOUNT {
                    //can execute
                    prop.executed = true;
                    env.storage().persistent().set(
                        &_proposal_id,
                        &prop
                    );
                    //reduce the amount of active proposals
                    dao.active_proposals = dao.active_proposals - 1;
                    env.storage().persistent().set(
                        &prop.dao,
                        &dao
                    );
                    return symbol_short!("done");
                }
                else {
                    return symbol_short!("lowvotes");
                }
            }
            else {
               return symbol_short!("notowner");
            }
        }
        else {
            return symbol_short!("dontexist"); //Proposal dont exists
        }
    }

    /**GETTER FUNCTIONS**/

    //returns dao information
    pub fn get_dao(env:Env, token:Address) -> DaoMeta {
        let dao: DAO =  env.storage().persistent().get(&token).unwrap();
        let name: String = dao.name;
        let description: String = dao.description;
        let owner: Address =  dao.owner;
        let url: String =  dao.url;
        let token: Address = dao.token;
        let members: u32 = dao.members.len();
        let active_proposals: u32 = dao.active_proposals;
        let proposals: Vec<u32> = dao.proposals_list;
        let created: u64 = dao.created;
        return DaoMeta {
            owner,
            token,
            name,
            description,
            url,
            members,
            active_proposals,
            proposals,
            created
        }
    }
    //get proposal lists
    pub fn get_dao_proposals(env:Env, token:Address) -> Vec<u32> {
        let dao: DAO =  env.storage().persistent().get(&token).unwrap();
        return dao.proposals_list;
    }
    //get dao members
    pub fn get_dao_members(env:Env, token:Address) -> Vec<Address> {
        let dao: DAO =  env.storage().persistent().get(&token).unwrap();
        return dao.members;
    }
    //returns proposal information
    pub fn get_proposal(env:Env, _proposal_id: u32) -> Proposal {
       return env.storage().persistent().get(&_proposal_id).unwrap();
    }
    //check if voter has voted on a proposal
    pub fn is_voted_proposal(env:Env, _proposal_id: u32, voter: Address) -> bool {
        let id = _proposal_id.clone();
        let voter_key: Vec<VoterKey> = vec![&env, VoterKey{voter, id}]; //voter key
        return env.storage().persistent().has(&voter_key);
    }
    //return a DAO metadata
    pub fn get_metadata(env: Env) -> DaoMetadata {
        let _p: &str = "metadata";
        return env.storage().persistent().get(&_p).unwrap();
    }
}

//to check if a dao has already being created
//DAO are mapped to token address
fn is_dao(env: &Env, token:&Address) -> bool {
   env.storage().persistent().has(&token) 
}
//to return new proposal id
fn get_id(env: &Env) -> ProposalId {
    let _p: &str = "proposal";
    const id: u32 = 4567;
    env.storage().instance().bump(0, 100000);
    if env.storage().instance().has(&_p) == true {
        let mut _prop: ProposalId = env.storage().instance().get(&_p).unwrap();
        _prop.id = _prop.id + 1;
        //save back
        env.storage().instance().set(
            &_p,
            &_prop
        );
        return _prop;
    }
    else {
        env.storage().instance().set(
            &_p,
            &ProposalId {
                id
            }
        );
        return ProposalId {
            id
        };
    } 
 }

 //to modify the metadata
fn modify_metadata(env: &Env, _type: &str, dao:Address) {
    let _p: &str = "metadata";
    if !env.storage().persistent().has(&_p) {
        let dao: u32 = 0;
        let proposal: u32 = 0;
        let users: u32 = 0;
        let votes: u32 = 0;
        let daos: Vec<Address> = vec![&env];
        env.storage().persistent().set(
            &_p,
            &DaoMetadata {
                dao,
                users,
                proposal,
                votes,
                daos
            }
        );
    }
    if env.storage().persistent().has(&_p) == true {
        let mut _meta: DaoMetadata = env.storage().persistent().get(&_p).unwrap();
        if _type == "dao" {
            _meta.dao = _meta.dao + 1;
        }
        else if _type == "proposal" {
            _meta.proposal = _meta.proposal + 1;
        }
        else if _type == "user" {
            _meta.users = _meta.users + 1;
        }
        else if _type == "votes" {
            _meta.votes = _meta.votes + 1;
        }
        else if _type == "daos" {
            _meta.daos.push_back(dao);
        }
        //save back
        env.storage().persistent().set(
            &_p,
            &_meta
        );
        
    }
    env.storage().persistent().bump(&_p, 0, 100000);
    
 }
//add new member if its not present
fn add_member_dao(env: &Env, dao: Address, member: Address) -> bool {
    let mut _dao: DAO = env.storage().persistent().get(&dao).unwrap();
    if !_dao.members.contains(&member) {
        //new member, add it
        _dao.members.push_back(member);
        //save back
        env.storage().persistent().set(
            &dao,
            &_dao
        );
        return true;
    }
    return false
}
 //to bump the smart contract lifetime
 fn bump_lifetime(env: &Env) {
   // env.storage().persistent().bump(0, 100000);
 }
 
 
