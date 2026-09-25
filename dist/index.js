import dotenv from "dotenv";
import ccnWatcher from "./worker/ccnWatcher.js";
dotenv.config();
console.log("App starting up...");
await new Promise((resolve) => setTimeout(resolve, 3000));
console.log("INDEX START");
debugger;
console.log("AFTER DEBUGGER");
// cron.schedule("*/2 * * * *", () => {
//   console.log("Starting SFTP task...");
//   ccnWatcher();
//   console.log("SFTP task completed.");
//   // Add your task logic here
// });
ccnWatcher();
//# sourceMappingURL=index.js.map