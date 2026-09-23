import stfp, { connectToSftp } from "../sftPClient/stfpClient";

const ccnWatcher = async () => {
  try {
    let run = false;
    while (run) {
      const sftp = await connectToSftp();
    }
  } catch (error) {
    console.log(error);
  }

  // Use stfp for SFTP operations
};
