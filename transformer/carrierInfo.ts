import { carrierInfoInterface } from "../types/generalTypes.js";
import { handleLoopAndGetData } from "../utils/utils.js";

const carrierInfo = async (d: any): Promise<carrierInfoInterface> => {
  const carrierInfoManifest = {
    Name: ["carrierName"],
    Code: ["Code"],
    carrierAdd1: ["Address1"],
    carrierAdd2: ["Address2"],
    carrierAdd3: ["Address3"],
    carrierAdd4: ["Address4"],
  };

  return await handleLoopAndGetData(carrierInfoManifest, d);
};

export default carrierInfo;
