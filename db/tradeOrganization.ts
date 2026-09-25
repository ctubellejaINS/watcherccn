import dbConnect from "./config.js";

export const getDataTradeOrg = async (where: any, attributes?: any) => {
  const db = await dbConnect();
  const r = await db
    .collection("tradeOrganizations")
    .find(where, { projection: attributes })
    .toArray();

  return r;
};
