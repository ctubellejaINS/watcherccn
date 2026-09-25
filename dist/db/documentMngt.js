// import { fs } from "fs/promises";
import { saveLogs } from "../utils/utils.js";
import dbConnect from "./config.js";
export const autoInsertdDocumentMngt = async (d) => {
    try {
        const db = await dbConnect();
        const document = db.collection("documentMngt");
        // check first if the applNo already exists
        var exists = true;
        var applNo;
        while (exists) {
            const uniqueId = Date.now().toString().slice(-7); // Last 7 digits for uniqueness
            applNo = `ALICT${uniqueId}`; // 12 characters total (e.g., SLICT1234567 or ALICT1234567)
            const r = await document.countDocuments({
                "docFields.manifestInfo.applNo": applNo,
            });
            if (!!!r) {
                exists = false;
            }
            else
                saveLogs("INFO", "Duplicate applNo detected. Retrying with a new random applNo.", new Date().toISOString());
        }
        const manifest = d.airmanifest;
        const genInfo = manifest.General_Info;
        const manifestInfo = {
            applNo,
            registryNo: genInfo.Register_number,
        };
        // const r = await db.collection("documentMngt")
    }
    catch (err) {
        saveLogs("ERROR", err.message, new Date().toISOString());
    }
};
//# sourceMappingURL=documentMngt.js.map