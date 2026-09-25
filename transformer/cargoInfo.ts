import { cargoInfoInterface } from "../types/generalTypes.js";
import { handleLoopAndGetData } from "../utils/utils.js";

const cargoInfo = async (d: any): Promise<cargoInfoInterface> => {
  const cargoInfoManifets = {
    Total_number_of_mawb: ["numberOfBL"],
    Gross_tonnage: ["grossTonnage"],
    Net_tonnage: ["netTonnage"],
  };
  return await handleLoopAndGetData(cargoInfoManifets, d);
};

export default cargoInfo;
