use soroban_sdk::{contracttype, Vec, Address, String};
 
pub(crate) const MIN_VOTES_AMOUNT: u64 = 1;

#[derive(Clone)]
#[contracttype]
pub struct Proposal {
    pub creator: Address,
    pub dao: Address,
    pub status: u64,
    pub start: u64,
    pub end: u64,
    pub yes_votes: u64,
    pub yes_voting_power: u64,
    pub no_votes: u64,
    pub no_voting_power: u64,
}
#[derive(Clone)]
#[contracttype]
pub struct ProposalVoter {
    pub voter_info: Vec<VoterInfo>,
    pub voters: Vec<Address>
}
#[derive(Clone)]
#[contracttype]
pub struct VoterInfo {
    pub voter: Address,
    pub vote_type: u64,
    pub voting_power: u64,
    pub time: u64,
    pub delegated: bool
}
#[derive(Clone)]
#[contracttype]
pub struct Votes {
    pub voter: Address,
    pub vote: u64
}
#[derive(Clone)]
#[contracttype]
pub struct ProposalGroupInfo {
    pub proposal: Proposal,
    pub voter_type: u64,
    pub delegatee: Vec<Address>
}
#[derive(Clone)]
#[contracttype]
pub struct DAO {
    pub owner: Address,
    pub token: Address,
    pub ban_members: Vec<Address>,
    pub admins: Vec<Address>,
    pub proposals_list: Vec<u64>,
    pub delegators: Vec<Delegates>,
    pub top_voters: Vec<Votes>,
    pub created: u64,
}
#[derive(Clone)]
#[contracttype]
pub struct DaoMeta {
    pub owner: Address,
    pub token: Address,
    pub proposals: Vec<u64>,
    pub ban_members: Vec<Address>,
    pub admins: Vec<Address>,
    pub top_voters: Vec<Votes>,
    pub created: u64
}
#[derive(Clone)]
#[contracttype]
pub struct DaoMetadata {
    pub votes: u32,
    pub daos: Vec<Address>
}
#[derive(Clone)]
#[contracttype]
pub struct ProposalId {
    pub id: u64,
}
#[derive(Clone)]
#[contracttype]
pub struct Delegates {
    pub delegator: Address,
    pub delegatee: Address
}