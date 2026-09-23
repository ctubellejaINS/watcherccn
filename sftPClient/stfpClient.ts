import SftpClient from "ssh2-sftp-client";

// configuration for stfp
const config = {
  host: process.env.SFTP_HOST,
  port: Number(process.env.SFTP_PORT),
  username: process.env.SFTP_USERNAME,
  password: process.env.SFTP_PASSWORD,
};

const stfp = new SftpClient();
// connect the ccn server using the configuration
export const connectToSftp = async () => {
  try {
    await stfp.connect(config);
    return stfp;
  } catch (error) {
    // console.error("Error connecting to SFTP server:", error);
    throw new Error(`Error connecting to SFTP server: ${error}`);
  }
};

export default stfp;
