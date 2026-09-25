import dbConnect from "./config.js";

export const getDepartureLocation = async (where: any) => {
  const db = await dbConnect();
  const collection = db.collection("refDeparturePlace");
  const r = await collection.findOne(where);
  return r;
};
