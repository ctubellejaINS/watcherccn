import fs from "fs/promises";
export const saveLogs = async (status, message, date) => {
    try {
        console.log(status, message);
        await fs.appendFile("logs/logs.txt", `${status} || ${message} || ${date} \n`, "utf-8");
    }
    catch (error) {
        console.error("Error saving logs:", error);
    }
};
export const delay = async (ms) => new Promise((resolve) => setTimeout(resolve, ms));
export const removeString = (files, stringToRemove) => {
    return files.map((file) => file.toLowerCase().replace(stringToRemove.toLowerCase(), "").toLowerCase());
};
export const regexFind = (files) => {
    return {
        name: {
            $in: files.map((f) => new RegExp(`^${f}`, "i")),
        },
    };
};
export const combineFindData = (paths, collections) => {
    const result = [];
    for (const collection of collections) {
        const path = paths.find((path) => path.toLowerCase().includes(collection.name.toLowerCase()));
        if (path) {
            result.push({
                path,
                name: collection.name,
                _id: collection._id,
            });
        }
    }
    return result;
};
//# sourceMappingURL=utils.js.map