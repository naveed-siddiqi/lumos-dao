use soroban_sdk::{contracttype, Vec, Address, String};
 
pub(crate) const MIN_DAO_TOKEN_BALANCE: i128 = 1;
pub(crate) const MIN_VOTES_AMOUNT: u32 = 1;

#[derive(Clone)]
#[contracttype]
pub struct Proposal {
    pub name: String,
    pub description: String,
    pub creator: Address,
    pub votes: u32,
    pub voters: Vec<Address>,
    pub dao: Address,
    pub executed: bool,
    pub start: u64,
    pub end: u64
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
    pub active_proposals: u32,
    pub proposals: u32,
    pub proposals_list: Vec<u32>,
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
    pub members: u32,
    pub active_proposals: u32,
    pub proposals: Vec<u32>,
    pub created: u64
}
#[derive(Clone)]
#[contracttype]
pub struct ProposalId {
    pub id: u32,
}
#[derive(Clone)]
#[contracttype]
pub struct VoterKey {
    pub voter: Address,
    pub id: u32,
}
#[derive(Clone)]
#[contracttype]
pub struct DaoMetadata {
    pub dao: u32,
    pub users: u32,
    pub proposal: u32,
    pub votes: u32,
    pub daos: Vec<Address>,
}
