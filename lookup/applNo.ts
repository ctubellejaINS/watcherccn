import dbConnect from "../db/config.js";
import { saveLogs } from "../utils/utils.js";

export const applNoGen = async () => {
  const db = dbConnect();
  const collection = (await db).collection("documentMngt");
  var exists = true;
  var applNo;
  while (exists) {
    const uniqueId = Date.now().toString().slice(-7); // Last 7 digits for uniqueness
    applNo = `ALICT${uniqueId}`; // 12 characters total (e.g., SLICT1234567 or ALICT1234567)

    const r = await collection.countDocuments({
      "docFields.manifestInfo.applNo": applNo,
    });

    if (!!!r) {
      exists = false;
    } else
      saveLogs(
        "INFO",
        "Duplicate applNo detected. Retrying with a new random applNo.",
        new Date().toISOString(),
      );
  }
  return { applNo: applNo };
};
