import dbConnect from "./config.js";
export const getDataTradeOrg = async (where, attributes) => {
    const db = await dbConnect();
    const r = await db
        .collection("tradeOrganizations")
        .find(where, { projection: attributes })
        .toArray();
    return r;
};
//# sourceMappingURL=tradeOrganization.js.map