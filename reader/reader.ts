import fs from "fs/promises";
import dotenv from "dotenv";
import { saveLogs } from "../utils/utils.js";
import moment from "moment";
import xmlParser from "../utils/xmlReader.js";
import manifestProcessor from "../processor/manifestProcessor.js";
dotenv.config();
const path = process.env.READER_PATH;
export const readerPath = async (): Promise<string[]> => {
  if (!path) {
    throw new Error("READER_PATH is not defined in the environment variables.");
  }

  const files = await fs.readdir(path);
  saveLogs("INFO", `Files read from ${path}`, new Date().toISOString());
  return files;
};
export const readLoopContent = async (files: any[]) => {
  const folderName = moment().subtract(2, "d").format("YYYY-MM-DD");
  for (const file of files) {
    const ccnPath = `${path}\\${file.path}\\OLD\\${folderName}`;
    const checkDirExists = await fs
      .access(ccnPath, fs.constants.F_OK)
      .then(() => true)
      .catch(() => false);
    // check if dir exists or not if not just logs if yes contunie
    if (!checkDirExists) {
      saveLogs(
        `INFO`,
        `NO FOLDER FOUND in ${ccnPath}`,
        new Date().toISOString(),
      );
    } else {
      const dirFiles = await fs.readdir(ccnPath);

      for (const dirFile of dirFiles) {
        const filesPath = ccnPath + "\\" + dirFile;

        const r = await xmlParser(filesPath);
        await manifestProcessor(r);
        //   save to database
      }
    }
  }
};
export const readFileContent = async (filePath: string): Promise<string> => {
  if (!path) {
    throw new Error("READER_PATH is not defined in the environment variables.");
  }
  const content = await fs.readFile(filePath, "utf-8");
  return content;
};
