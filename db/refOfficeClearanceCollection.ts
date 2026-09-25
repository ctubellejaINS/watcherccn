import dbConnect from "../db/config.js";

const getbocOfCode = async (where: any) => {
  const db = await dbConnect();
  const collection = db.collection("refOfficeClearance");
  const r = await collection.findOne(where);
  return r;
};

export { getbocOfCode };
