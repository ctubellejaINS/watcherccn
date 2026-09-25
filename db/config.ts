import mongodb, { MongoClient } from "mongodb";
import { saveLogs } from "../utils/utils.js";
const dbConfig = {
  url: process.env.MONGO_URL || "mongodb://localhost:27017",
  dbName: process.env.MONGO_DB_NAME || "nextjs_baseline",
};
const client = new MongoClient(dbConfig.url);
let db: mongodb.Db | null = null;
const dbConnect = async () => {
  if (db) {
    return db;
  }
  await client.connect();
  saveLogs("INFO", `Connected to MongoDB`, new Date().toISOString());
  db = client.db(dbConfig.dbName);
  return db;
};

export default dbConnect;
