import dbConnect from "./config.js";

export const getDestinationLocation = async (d: any) => {
  const db = await dbConnect();
  const collection = db.collection("refDestinationPlace");
  const r = await collection.findOne(d);
  return r;
};
