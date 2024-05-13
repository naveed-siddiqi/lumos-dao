/**Lumst DAO Contract
*/

//CREATES
use soroban_sdk::{contract, contractimpl, token, symbol_short, vec, Symbol, Address, Env, Vec, String};
use crate::storage::{Proposal, DAO, ProposalId, DaoMetadata, DaoMeta, Votes, ProposalVoter, VoterInfo, Delegates, ProposalGroupInfo};

#[contract]
pub struct DaoContract;

#[contractimpl]
impl DaoContract {
     
    //to create a new DAO with owner address, token address and ame
    pub fn create(env: Env, owner: Address, _token: Address) -> bool{
        owner.require_auth();
        if !is_dao(&env, &_token) {
            //create a dao
            let token = _token.clone();
            let ban_members: Vec<Address> = vec![&env];
            let admins: Vec<Address> = vec![&env];
            let proposals_list: Vec<u64> = vec![&env];
            let delegators: Vec<Delegates> = vec![&env];
            let top_voters: Vec<Votes> = vec![&env];
            let created: u64 = env.ledger().timestamp();
            env.storage().instance().set(
                &_token,
                &DAO {
                    owner,
                    token,
                    ban_members,
                    admins,
                    proposals_list,
                    delegators,
                    top_voters,
                    created
                },
            );
            //save list of daos
            modify_metadata(&env, _token, &"daos");
            return true
        }   
        else {
            return false
        } 
    }

    //to create a proposal
    pub fn create_proposal(env: Env, creator:Address, _token: Address) -> u64 {
        //check if the dao exists
        creator.require_auth();
        if is_dao(&env, &_token) {
            let mut _dao: DAO = env.storage().instance().get(&_token).unwrap();
            if !_dao.ban_members.contains(&creator) {
                    let dao = _token.clone();
                    let _prop: ProposalId = get_id(&env);
                    let status = 0; //0 inactive, 1 - active, 2 - rejected, 3 - funded
                    let yes_votes = 0;
                    let yes_voting_power = 0;
                    let no_votes = 0;
                    let no_voting_power = 0;
                    let mut start: u64 = env.ledger().timestamp();
                    const action: u64 = 2;
                    let end: u64 = start + 432000; //5 days
                    env.storage().instance().set(
                        &_prop.id,
                        &Proposal {
                            creator,
                            dao,
                            status,
                            start,
                            end,
                            yes_votes,
                            yes_voting_power,
                            no_votes,
                            no_voting_power,
                        },
                    );
                    let voter_info: Vec<VoterInfo> = vec![&env];
                    let voters: Vec<Address> = vec![&env];
                    //save proposal info
                    env.storage().instance().set(
                        &(_prop.id + 1),
                        &ProposalVoter {
                            voter_info,
                            voters
                        },
                    );
                    //increment the total proposals
                    _dao.proposals_list.push_back(_prop.id.clone());
                    env.storage().instance().set(&_token, &_dao);
                    return _prop.id;
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
    }

    /*to vote on a proposal
    voter can only vote once */
    pub fn vote_on_proposal(env: Env, _proposal_id:u64, voters: Address, vote_type: u64, voting_power: u64) -> Symbol {
        //check if the proposal exists
        voters.require_auth();
        if env.storage().instance().has(&_proposal_id) {
            //check if proposal is still going on
            let mut prop: Proposal = env.storage().instance().get(&_proposal_id).unwrap();
            let mut dao: DAO = env.storage().instance().get(&prop.dao).unwrap();
            if prop.status == 1 {
                if !dao.ban_members.contains(&voters) {
                    //do date comparison
                    let cDate: u64 = env.ledger().timestamp();
                    if cDate >= prop.start {
                        if cDate <= prop.end { 
                            if prop.status == 1 {
                                let mut voter = voters;
                                let signer = voter.clone();
                                let _dao = prop.dao.clone();
                                let action = vote_type.clone() + 2;
                                let zero: u64 = _proposal_id.clone();
                                //get the prop voters info, the info is in +1 of the proposal id
                                let mut voters: ProposalVoter = env.storage().instance().get(&(_proposal_id + 1)).unwrap();
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
                                            dao.top_voters.push_back(Votes{voter:voter.clone(), vote});
                                        }
                                        voters.voters.push_back(voter.clone());
                                        let time = env.ledger().timestamp();
                                        let _voter = voter.clone();
                                        //check if it was a delegated vote
                                        let voter_delegators: Vec<Address> = Self::get_delegator(env.clone(), _dao.clone(), voter.clone());
                                        let mut delegated:bool = false;
                                        if !voter_delegators.is_empty() {
                                            delegated = true;
                                        }
                                        //save voters info
                                        voters.voter_info.push_back(
                                            VoterInfo{
                                                voter,
                                                vote_type,
                                                voting_power,
                                                time,
                                                delegated,
                                            }
                                        );
                                        //save back the proposal
                                        env.storage().instance().set(
                                            &_proposal_id,
                                            &prop
                                        );
                                        env.storage().instance().set(
                                            &(_proposal_id + 1),
                                            &voters
                                        );
                                        //save back the dao
                                        env.storage().instance().set(&prop.dao, &dao);
                                        modify_metadata(&env, dao.token.clone(), &"votes");
                                        return symbol_short!("voted");
                                }
                                else {
                                        return symbol_short!("hasvoted");
                                }
                            }
                            else {
                                return symbol_short!("inactive");
                            }
                        }
                        else {
                            //remove it from active proposa;
                            return symbol_short!("ended");
                        }
                    }
                    else {
                        return symbol_short!("notstart"); //Proposal hasn't started
                    }
                }
                else {
                    return symbol_short!("banned");
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
    pub fn execute_proposal(env: Env, _proposal_id:u64, owner: Address, status: u64, _type: u64) -> Symbol {
        owner.require_auth();
        //check if the proposal exists
        if env.storage().instance().has(&_proposal_id) {
            //check if proposal is still going on
            let mut prop: Proposal = env.storage().instance().get(&_proposal_id).unwrap();
            let mut dao: DAO = env.storage().instance().get(&prop.dao).unwrap();
            if !dao.ban_members.contains(&owner) {
                //check if owner or admin
                if dao.admins.contains(&owner) || dao.owner == owner {
                    if prop.status != 2 && prop.status != 3 {
                        if status == 2 || status == 1 {
                            prop.status = status;
                            //making proposal active, increment it
                            if status == 1 {
                                //set the date to new date
                                prop.start = env.ledger().timestamp();
                                prop.end = prop.start + 432000; //5 days
                            }
                            else if status == 2 {
                                let mut propIndx:u32 = 0;
                                let mut flg:bool = false;
                                //rejected, remove the proposal from the list
                                for propId in dao.proposals_list.iter() {
                                    if propId == _proposal_id  {
                                        flg = true;
                                        break; 
                                    }  
                                    propIndx =  propIndx + 1;
                                }
                                if flg {
                                    dao.proposals_list.remove(propIndx);
                                }
                            }
                            //save back
                            env.storage().instance().set(
                                &_proposal_id,
                                &prop
                            );
                            env.storage().instance().set(
                                &prop.dao,
                                &dao
                            );
                            return symbol_short!("done");
                        }
                        else {
                            return symbol_short!("invalid");
                        }
                    }
                    else {
                        return symbol_short!("rejected");
                    }
                }
                else {
                    return symbol_short!("notauth");
                }
            }
            else{
                return symbol_short!("banned");
            }
        }
        else {
            return symbol_short!("dontexist"); //Proposal dont exists
        }
    }

    //to delagate a delegatee
    pub fn add_admin(env: Env, dao:Address, owner:Address, admin: Address) -> Symbol {
        owner.require_auth();
        //check if the delegator exists
        let mut _dao: DAO = env.storage().instance().get(&dao).unwrap();
        if !_dao.admins.contains(&admin) {
            //new member, add it
            _dao.admins.push_back(admin);
            //save back
            env.storage().instance().set(
                &dao,
                &_dao
            );
        }
        return symbol_short!("true");
    }
    //to remove admin
    pub fn remove_admin(env: Env, dao:Address, owner:Address, admin: Address) -> Symbol {
        owner.require_auth();
        //check if the delegator exists
        let mut _dao: DAO = env.storage().instance().get(&dao).unwrap();
        if _dao.admins.contains(&admin) {
            _dao.admins.remove(_dao.admins.first_index_of(&admin).unwrap());
            //save back
            env.storage().instance().set(
                &dao,
                &_dao
            );
        }
        return symbol_short!("true");
    }
    //to delagate a delegatee
    pub fn add_delegate(env: Env, dao:Address, delegator:Address, delegatee: Address) -> Symbol {
        //check if the delegator exists
        add_delegate_dao(&env, dao, delegator, delegatee);
        return symbol_short!("true");
    }
    //to ban a member
    pub fn ban_member(env: Env, dao:Address, member:Address) -> Symbol {
        //check if the delegator exists
        if ban_member_dao(&env, dao, member) == true {
            return symbol_short!("true");
        }
        else {
            return symbol_short!("false");
        }
    }
    //to unban a member
    pub fn un_ban_member(env: Env, dao:Address, member:Address) -> Symbol {
        //check if the delegator exists
        if unban_member_dao(&env, dao, member) == true {
            return symbol_short!("true");
        }
        else {
            return symbol_short!("false");
        }
    }
    /**GETTER FUNCTIONS**/

    //return dao meta functions
    pub fn get_metadata(env: Env) -> DaoMetadata {
        let _p: &str = "metadata";
        return env.storage().instance().get(&_p).unwrap();
    }
    
    //returns dao information
    pub fn get_dao(env:Env, token:Address) -> DaoMeta {
        let dao: DAO =  env.storage().instance().get(&token).unwrap();
        let owner: Address =  dao.owner;
        let token: Address = dao.token;
        let ban_members: Vec<Address> = dao.ban_members;
        let admins: Vec<Address> = dao.admins;
        let proposals: Vec<u64> = dao.proposals_list;
        let top_voters: Vec<Votes> = dao.top_voters;
        let created: u64 = dao.created;
        return DaoMeta {
            owner,
            token,
            proposals,
            ban_members,
            admins,
            top_voters,
            created
        }
    }
    //returns all dao information
    pub fn get_all_dao(env:Env, token:Vec<Address>) -> Vec<DaoMeta> {
        //loop through
        let mut daos:Vec<DaoMeta> = vec![&env];
        for tokens in token {
            let dao: DAO =  env.storage().instance().get(&tokens).unwrap();
            let owner: Address =  dao.owner;
            let token: Address = dao.token;
            let ban_members: Vec<Address> = dao.ban_members;
            let proposals: Vec<u64> = dao.proposals_list;
            let admins: Vec<Address> = dao.admins;
            let top_voters: Vec<Votes> = dao.top_voters;
            let created: u64 = dao.created;
            daos.push_back(DaoMeta {
                owner,
                token,
                proposals,
                ban_members,
                admins,
                top_voters,
                created
            });
        }
        
        return daos;
    }
    //get proposal lists
    pub fn get_dao_proposals(env:Env, token:Address) -> Vec<u64> {
        let dao: DAO =  env.storage().instance().get(&token).unwrap();
        return dao.proposals_list;
    }
    //returns all proposal information
    pub fn get_all_proposal(env:Env, proposal_id:Vec<u64>) -> Vec<Proposal> {
        let mut proposals: Vec<Proposal> = vec![&env];
        for propId in proposal_id {
            let mut prop: Proposal =  env.storage().instance().get(&propId).unwrap();
            if env.ledger().timestamp() > prop.end && prop.status == 1 {prop.status = 4;}
            proposals.push_back(prop);
        }
        return proposals;
     }
    //returns proposal information
    pub fn get_proposal(env:Env, _proposal_id: u64) -> Proposal {
       let mut prop: Proposal =  env.storage().instance().get(&_proposal_id).unwrap();
       if env.ledger().timestamp() > prop.end && prop.status == 1 {prop.status = 4;}
       return prop;
    }
    //returns proposal voters info
    pub fn get_proposal_voters(env:Env, _proposal_id: u64) -> Vec<VoterInfo> {
        let mut prop: ProposalVoter =  env.storage().instance().get(&(_proposal_id + 1)).unwrap();
        return prop.voter_info;
    }
    //returns group info on proposal
    pub fn get_proposal_user_group_info (env:Env, _proposal_id: u64, voter: Address, dao:Address) -> ProposalGroupInfo {
        let mut proposal: Proposal =  env.storage().instance().get(&_proposal_id).unwrap();
        if env.ledger().timestamp() > proposal.end && proposal.status == 1 {proposal.status = 4;}
        //fetch the voter info
        let delegator = voter.clone();
        let voters: ProposalVoter = env.storage().instance().get(&(_proposal_id + 1)).unwrap();
        let mut voter_type:u64 = 0;
        if voters.voters.contains(&voter) {
            for voterInfo in voters.voter_info {
                if voterInfo.voter == voter {
                    voter_type =  voterInfo.vote_type;
                    break;
                }
            }
        }  
        //fetch delegatee
        let _dao: DAO = env.storage().instance().get(&dao).unwrap();
        let flg: bool = false;
        let mut delegatee: Vec<Address> = vec![&env];
        for item in _dao.delegators {
            if item.delegator == delegator  && item.delegatee != delegator {
                delegatee.push_back(item.delegatee)
            }
        }

        return ProposalGroupInfo {
            proposal,
            voter_type,
            delegatee
        }
    }
    //check if voter has voted on a proposal
    pub fn is_voted_proposal(env:Env, _proposal_id: u64, voter: Address) -> bool {
        let id = _proposal_id.clone();
        //get the prop voters info, the info is in +1 of the proposal id
        let voters: ProposalVoter = env.storage().instance().get(&(_proposal_id + 1)).unwrap();
        return voters.voters.contains(&voter);         
    }
    //return what a voter voted on a proposal
    pub fn get_vote_type_proposal(env:Env, _proposal_id: u64, voter: Address) -> u64 {
        let id = _proposal_id.clone();
        //get the prop voters info, the info is in +1 of the proposal id
        let voters: ProposalVoter = env.storage().instance().get(&(_proposal_id + 1)).unwrap();
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
    //to return a delegated address
    pub fn get_delegator(env: Env, dao:Address, delegatee: Address) -> Vec<Address> {
        let _dao: DAO = env.storage().instance().get(&dao).unwrap();
        let flg: bool = false;
        let mut delegators: Vec<Address> = vec![&env];
        for item in _dao.delegators {
            if item.delegatee == delegatee && item.delegator != delegatee {
                delegators.push_back(item.delegator)
            }
        }
        return delegators;
    }
    //to return delegatees
    pub fn get_delegatee(env: Env, dao:Address, delegator: Address) -> Vec<Address> {
        let _dao: DAO = env.storage().instance().get(&dao).unwrap();
        let flg: bool = false;
        let mut delegatee: Vec<Address> = vec![&env];
        for item in _dao.delegators {
            if item.delegator == delegator  && item.delegatee != delegator {
                delegatee.push_back(item.delegatee)
            }
        }
        return delegatee;
    }
    //to return if banned
    pub fn get_ban(env: Env, dao:Address, member: Address) -> bool {
        let _dao: DAO = env.storage().instance().get(&dao).unwrap();
        if _dao.ban_members.contains(&member) {
             return true
        }
        return false;
    }
    //to return the contract address
    pub fn get_my_address(env: Env) -> Address {
        return env.current_contract_address();
    }
}

//to check if a dao has already being created
//DAO are mapped to token address
fn is_dao(env: &Env, token:&Address) -> bool {
   env.storage().instance().has(&token) 
}

/* MODIFIERS */

//to return new proposal id
fn get_id(env: &Env) -> ProposalId {
    let _p: &str = "proposal";
    const id: u64 = 4567;
    if env.storage().instance().has(&_p) == true {
        let mut _prop: ProposalId = env.storage().instance().get(&_p).unwrap();
        _prop.id = _prop.id + 2;
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
fn modify_metadata(env: &Env, dao:Address, _type: &str) -> bool {
    let _p: &str = "metadata";
    if !env.storage().instance().has(&_p) {
        let daos: Vec<Address> = vec![&env, dao];
        let votes:u32 = 0;
        env.storage().instance().set(
            &_p,
            &DaoMetadata {
                votes,
                daos
            }
        );
        return true;
    }
    if env.storage().instance().has(&_p) == true {
        let mut meta: DaoMetadata = env.storage().instance().get(&_p).unwrap();
        if _type == "votes" {
            meta.votes = meta.votes + 1;
        }
        else if _type == "daos" {
            meta.daos.push_back(dao);
        }
        //save back
        env.storage().instance().set(
            &_p,
            &meta
        );
    }
    return true;
 }

//to add new delegate
 fn add_delegate_dao(env: &Env, dao: Address, delegator: Address, delegatee: Address) -> bool {
    let mut _dao: DAO = env.storage().instance().get(&dao).unwrap();
    let mut flg: bool = false;
    for i in 0.._dao.delegators.len() {
        let mut item: Delegates = _dao.delegators.get(i).unwrap();
        if item.delegator == delegator {
            //already present, update field
            item.delegatee = delegatee.clone();
            _dao.delegators.set(i, item);
            flg = true;
        }

    }
    if !flg {
        //add new
        _dao.delegators.push_back(
            Delegates {
                delegator,
                delegatee,
            }
        )
    }
    //save it back to storage
    env.storage().instance().set(
        &dao,
        &_dao
    );
    return true
}
//to ban memebers
fn ban_member_dao(env: &Env, dao: Address, member: Address) -> bool {
    let mut _dao: DAO = env.storage().instance().get(&dao).unwrap();
    if !_dao.ban_members.contains(&member) {
        //new member, add it
        _dao.ban_members.push_back(member);
        //save back
        env.storage().instance().set(
            &dao,
            &_dao
        );
        return true;
    }
    return false
}
//to unban members
fn unban_member_dao(env: &Env, dao: Address, member: Address) -> bool {
    let mut _dao: DAO = env.storage().instance().get(&dao).unwrap();
    if _dao.ban_members.contains(&member) {
        //new member, add it
        _dao.ban_members.remove(_dao.ban_members.first_index_of(&member).unwrap());
        //save back
        env.storage().instance().set(
            &dao,
            &_dao
        );
    }
    return true
} 
