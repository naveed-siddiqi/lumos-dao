/**Lumst DAO Contract
*/

//CREATES
use soroban_sdk::{contract, contractimpl, token, symbol_short, vec, Symbol, Address, Env, Vec, String};
use crate::storage::{MIN_DAO_TOKEN_BALANCE, MIN_VOTES_AMOUNT, Proposal, DAO, ProposalId, DaoMetadata, DaoMeta, Votes, ProposalVoter, VoterInfo};

#[contract]
pub struct DaoContract;

#[contractimpl]
impl DaoContract {
     
    //to create a new DAO with owner address, token address and ame
    pub fn create(env: Env, owner: Address, _token: Address, name: String, description:String, url: String, _created: u64) -> bool{
       
        if !is_dao(&env, &_token) {
            //create a dao
            let token = _token.clone();
            let _owner: Address = owner.clone();
            let members: Vec<Address> = vec![&env, _owner];
            let proposals_list: Vec<u64> = vec![&env];
            let top_voters: Vec<Votes> = vec![&env];
            const active_proposals: u64 = 0;
            const proposals: u64 = 0;
            let created: u64 = env.ledger().timestamp();
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
                    top_voters,
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
    pub fn create_proposal(env: Env, creator:Address, _token: Address, name:String, description: String, start_date:u64, links:String) -> u64 {
        //check if the dao exists
        if is_dao(&env, &_token) {
            let mut _dao: DAO = env.storage().persistent().get(&_token).unwrap();
            let creator_balance: i128 = 1; //Not implementing creating per balancetoken::Client::new(&env, &_dao.token).balance(&creator);
            if creator_balance >= MIN_DAO_TOKEN_BALANCE {
                let dao = _token.clone();
                let executed = false;
                let _prop: ProposalId = get_id(&env);
                let voters = 0;
                let status = 1; //1 - active, 0 - ended
                let yes_votes = 0;
                let yes_voting_power = 0;
                let no_votes = 0;
                let no_voting_power = 0;
                let _creator = creator.clone();
                let mut start: u64 = env.ledger().timestamp();
                // //cross check start date
                // if start < start_date {
                //     start = start_date;
                // }
                let end: u64 = start + 432000; //5 days
                env.storage().persistent().set(
                    &_prop.id,
                    &Proposal {
                        name,
                        description,
                        creator,
                        voters,
                        dao,
                        executed,
                        status,
                        start,
                        end,
                        links,
                        yes_votes,
                        yes_voting_power,
                        no_votes,
                        no_voting_power,
                    },
                );
                let voter_info: Vec<VoterInfo> = vec![&env];
                let voters: Vec<Address> = vec![&env];
                //save proposal info
                env.storage().persistent().set(
                    &(_prop.id + 1),
                    &ProposalVoter {
                        voter_info,
                        voters
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
    pub fn vote_on_proposal(env: Env, _proposal_id:u64, voters: Address, vote_type: u64, voting_power: u64) -> Symbol {
        //check if the proposal exists
        if env.storage().persistent().has(&_proposal_id) {
            //check if proposal is still going on
            let mut prop: Proposal = env.storage().persistent().get(&_proposal_id).unwrap();
            //do date comparison
            let cDate: u64 = env.ledger().timestamp();
            let mut dao: DAO = env.storage().persistent().get(&prop.dao).unwrap();
            if cDate >= prop.start {
                if cDate <= prop.end { 
                    if prop.executed == false {
                        let mut voter = voters;
                        //check if user has enough of the DAO Token to vote
                        let voter_balance: i128 = 1; //token::Client::new(&env, &dao.token).balance(&voter);
                        if voter_balance > MIN_DAO_TOKEN_BALANCE {
                            //can vote
                            //get the prop voters info, the info is in +1 of the proposal id
                            let mut voters: ProposalVoter = env.storage().persistent().get(&(_proposal_id + 1)).unwrap();
                            if !voters.voters.contains(&voter) {
                                //has not voted
                                if vote_type == 1 {
                                    //yes voting
                                    prop.yes_votes = prop.yes_votes + 1;
                                    prop.yes_voting_power = prop.yes_voting_power + voting_power;
                                }
                                else if vote_type == 2 {
                                    //yes voting
                                    prop.no_votes = prop.no_votes + 1;
                                    prop.no_voting_power = prop.no_voting_power + voting_power;
                                }
                                let mut i = 0; let mut flg: bool = false;
                                //modify the top voters for dao
                                let _votersinfo = dao.top_voters.clone();
                                for mut _voterInfo in _votersinfo {
                                    if _voterInfo.voter == voter {
                                        //update its vote number
                                        _voterInfo.vote += 1;
                                        dao.top_voters.set(i, _voterInfo);
                                        flg = true;
                                        break;
                                    }
                                    i += 1;
                                }
                                let __voter = voter.clone();
                                if !flg {
                                    let vote = 1;
                                    //add new voter info
                                    dao.top_voters.push_back(Votes{voter, vote});
                                }
                                prop.voters += 1;
                                voter = __voter;
                                voters.voters.push_back(voter.clone());
                                let time = env.ledger().timestamp();
                                let _voter = voter.clone();
                                //save voters info
                                voters.voter_info.push_back(
                                    VoterInfo{
                                        voter,
                                        vote_type,
                                        voting_power,
                                        time
                                    }
                                );
                                //save back the proposal
                                env.storage().persistent().set(
                                    &_proposal_id,
                                    &prop
                                );
                                env.storage().persistent().set(
                                    &(_proposal_id + 1),
                                    &voters
                                );
                                //save back the dao
                                env.storage().persistent().set(&prop.dao, &dao);
                                //save back this member as part of the dao members
                                if add_member_dao(&env, dao.token.clone(), _voter) == true {
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
                    prop.status = 0; //change the status
                    dao.active_proposals -= 1;
                    env.storage().persistent().set(
                        &_proposal_id,
                        &prop
                    );
                    env.storage().persistent().set(&prop.dao, &dao);
                    //remove it from active proposa;
                    return symbol_short!("ended");
                }
            }
            else {
                return symbol_short!("notstart"); //Proposal hasn't started
            }
        }
        else {
            return symbol_short!("dontexist"); //Proposal dont exists
        }
    }

    //execute a proposal
    pub fn execute_proposal(env: Env, _proposal_id:u64, owner: Address) -> Symbol {
        //check if the proposal exists
        if env.storage().persistent().has(&_proposal_id) {
            //check if proposal is still going on
            let mut prop: Proposal = env.storage().persistent().get(&_proposal_id).unwrap();
            let mut dao: DAO = env.storage().persistent().get(&prop.dao).unwrap();
            if dao.owner == owner {
                //can execute
                if (prop.no_votes + prop.yes_votes) >= MIN_VOTES_AMOUNT {
                    //can execute
                    prop.executed = true;
                    prop.status = 0;
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
        let members: u64 = dao.members.len().into();
        let active_proposals: u64 = dao.active_proposals;
        let proposals: Vec<u64> = dao.proposals_list;
        let created: u64 = dao.created;
        let top_voters = dao.top_voters;
        return DaoMeta {
            owner,
            token,
            name,
            description,
            url,
            members,
            active_proposals,
            proposals,
            top_voters,
            created
        }
    }
    //get proposal lists
    pub fn get_dao_proposals(env:Env, token:Address) -> Vec<u64> {
        let dao: DAO =  env.storage().persistent().get(&token).unwrap();
        return dao.proposals_list;
    }
    //get dao members
    pub fn get_dao_members(env:Env, token:Address) -> Vec<Address> {
        let dao: DAO =  env.storage().persistent().get(&token).unwrap();
        return dao.members;
    }
    //returns proposal information
    pub fn get_proposal(env:Env, _proposal_id: u64) -> Proposal {
       let mut prop: Proposal =  env.storage().persistent().get(&_proposal_id).unwrap();
       if env.ledger().timestamp() > prop.end {prop.status = 0;}
       return prop;
    }
    //returns proposal voters info
    pub fn get_proposal_voters(env:Env, _proposal_id: u64) -> Vec<VoterInfo> {
        let mut prop: ProposalVoter =  env.storage().persistent().get(&(_proposal_id + 1)).unwrap();
        return prop.voter_info;
     }
    //check if voter has voted on a proposal
    pub fn is_voted_proposal(env:Env, _proposal_id: u64, voter: Address) -> bool {
        let id = _proposal_id.clone();
        //get the prop voters info, the info is in +1 of the proposal id
        let voters: ProposalVoter = env.storage().persistent().get(&(_proposal_id + 1)).unwrap();
        return voters.voters.contains(&voter);         
    }
    //return what a voter voted on a proposal
    pub fn get_vote_type_proposal(env:Env, _proposal_id: u64, voter: Address) -> u64 {
        let id = _proposal_id.clone();
        //get the prop voters info, the info is in +1 of the proposal id
        let voters: ProposalVoter = env.storage().persistent().get(&(_proposal_id + 1)).unwrap();
        if voters.voters.contains(&voter) {
            let mut voter_type:u64 = 0;
            for voterInfo in voters.voter_info {
                if voterInfo.voter == voter {
                    voter_type =  voterInfo.vote_type;
                    break;
                }
            }
            return voter_type;
        }  
        else {
            return 0;
        }    
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
    const id: u64 = 4567;
    if env.storage().persistent().has(&_p) == true {
        let mut _prop: ProposalId = env.storage().persistent().get(&_p).unwrap();
        _prop.id = _prop.id + 2;
        //save back
        env.storage().persistent().set(
            &_p,
            &_prop
        );
        return _prop;
    }
    else {
        env.storage().persistent().set(
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
        let dao: u64 = 0;
        let proposal: u64 = 0;
        let users: u64 = 0;
        let votes: u64 = 0;
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
  
