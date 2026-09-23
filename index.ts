import cron from "node-cron";
import dotenv from "dotenv";
dotenv.config();
cron.schedule("*/2 * * * *", () => {
  console.log("Starting SFTP task...");
  // Add your task logic here
});
