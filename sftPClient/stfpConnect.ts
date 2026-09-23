import moment from "moment";
import fs from "fs";
import { connectToSftp } from "./stfpClient";
import dotenv from "dotenv";
dotenv.config();
const delay = async (ms: number) =>
  new Promise((resolve) => setTimeout(resolve, ms));
const stfpConnect = async () => {
  const fileToDownload = moment().format("YYYYMMDD") + ".txt";
  let run = false;
  while (run) {
    try {
      const stfp = await connectToSftp();
      const exist = await stfp.exists(process.env.SFTP_DIRECTORY || "");
      if (!exist) {
        saveLogs(
          `Directory does not exist on SFTP server at ${new Date().toISOString()}\n`,
        );
        console.error("Directory does not exist on SFTP server.");
        run = false;
      }
      const fileList = await stfp.list(process.env.SFTP_DIRECTORY || "");
      if (fileList.length === 0) {
        console.error("No files found in the directory.");
        await saveLogs(
          `No files found in the directory at ${new Date().toISOString()}\n`,
        );

        run = false;
      }
      const matchFiles = fileList.filter(
        (file) => file.name === fileToDownload,
      );
      if (matchFiles.length === 0) {
        await saveLogs(
          `No files found matching ${fileToDownload} in the directory at ${new Date().toISOString()}\n`,
        );
        console.error(
          `No files found matching ${fileToDownload} in the directory.`,
        );
      }
      matchFiles.forEach(async (file) => {
        const localPath = `./downloads/${file.name}`;
        const remotePath = `${process.env.SFTP_DIRECTORY}/${file.name}`;
        await stfp.get(remotePath, localPath);
        console.log(`Downloaded ${file.name} to ${localPath}`);
      });
      run = false;
    } catch (err: any) {
      await delay(5000); // Wait for 5 seconds before retrying
      console.error(`Error connecting to SFTP server: ${err.message}`);
      await saveLogs(
        `Error connecting to SFTP server: ${err.message} at ${new Date().toISOString()}\n`,
      );
      console.log("retrying in 5 seconds....");
    }
  }
};

const saveLogs = async (message: string) => {
  await fs.appendFile(
    "logs/log.txt",
    `No files found in the directory at ${new Date().toISOString()}\n`,
    (err) => {
      if (err) {
        console.error("Error writing to log file:", err);
      }
    },
  );
};
