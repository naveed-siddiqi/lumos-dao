use soroban_sdk::{contracttype, Vec, Address, String};
 
pub(crate) const MIN_DAO_TOKEN_BALANCE: i128 = 0;
pub(crate) const MIN_VOTES_AMOUNT: u64 = 1;

#[derive(Clone)]
#[contracttype]
pub struct Proposal {
    pub name: String,
    pub description: String,
    pub creator: Address,
    pub voters: u64,
    pub dao: Address,
    pub executed: bool,
    pub status: u64,
    pub start: u64,
    pub end: u64,
    pub links: String,
    pub yes_votes: u64,
    pub yes_voting_power: u64,
    pub no_votes: u64,
    pub no_voting_power: u64
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
    pub time: u64
}
#[derive(Clone)]
#[contracttype]
pub struct Votes {
    pub voter: Address,
    pub vote: u64
}
#[derive(Clone)]
#[contracttype]
pub struct DAO {
    pub owner: Address,
    pub token: Address,
    pub name: String,
    pub description: String,
    pub url: String,
    pub members: Vec<Address>,
    pub active_proposals: u64,
    pub proposals: u64,
    pub proposals_list: Vec<u64>,
    pub top_voters: Vec<Votes>,
    pub created: u64
}
#[derive(Clone)]
#[contracttype]
pub struct DaoMeta {
    pub owner: Address,
    pub token: Address,
    pub name: String,
    pub url: String,
    pub description: String,
    pub members: u64,
    pub active_proposals: u64,
    pub proposals: Vec<u64>,
    pub top_voters: Vec<Votes>,
    pub created: u64
}
#[derive(Clone)]
#[contracttype]
pub struct ProposalId {
    pub id: u64,
}
#[derive(Clone)]
#[contracttype]
pub struct DaoMetadata {
    pub dao: u64,
    pub users: u64,
    pub proposal: u64,
    pub votes: u64,
    pub daos: Vec<Address>,
}
