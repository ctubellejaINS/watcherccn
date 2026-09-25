import { saveLogs } from "./utils.js";
import { XMLParser } from "@nodable/flexible-xml-parser";
import { createReadStream } from "fs";
const xmlParser = async (filePath) => {
    const parser = new XMLParser({ skip: { attributes: true } });
    // read the xml file and parse it to json
    saveLogs("INFO", `Starting xml parsing stream in ${filePath}`, ` ${new Date().toISOString()}`);
    const stream = createReadStream(filePath);
    const result = await parser.parseStream(stream);
    return result;
};
export default xmlParser;
//# sourceMappingURL=xmlReader.js.map