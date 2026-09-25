import dbConnect from "./config.js";

export const getCountry = async (where: any): Promise<any> => {
  const db = await dbConnect();
  const collection = db.collection("refCountry");
  return await collection.findOne(where);
};
