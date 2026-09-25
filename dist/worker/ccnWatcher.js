import { readerPath, readLoopContent } from "../reader/reader.js";
import { combineFindData, regexFind, removeString, saveLogs, } from "../utils/utils.js";
import { getDataTradeOrg } from "../db/tradeOrganization.js";
const ccnWatcher = async () => {
    try {
        saveLogs("INFO", `Starting CCN Watcher`, new Date().toISOString());
        const files = await readerPath();
        if (files.length === 0) {
            throw new Error("No files found in the specified directory.");
        }
        const reFiles = removeString(files, "airways");
        // get where regex
        const where = regexFind(reFiles);
        const orgList = await getDataTradeOrg(where, {
            _id: 1,
            name: 1,
            organizationId: 1,
        });
        if (orgList.length <= 0) {
            throw new Error("Query returned 0 organization records");
        }
        const combinedPath = combineFindData(files, orgList);
        readLoopContent(combinedPath);
        // start searching the db first make it regex
    }
    catch (error) {
        saveLogs("ERROR", `${error.message}`, new Date().toISOString());
    }
    // Use stfp for SFTP operations
};
export default ccnWatcher;
//# sourceMappingURL=ccnWatcher.js.map