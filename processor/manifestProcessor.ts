import cargoInfo from "../transformer/cargoInfo.js";
import carrierInfo from "../transformer/carrierInfo.js";
import generalInfoProcess from "../transformer/generalInfo.js";
import transportInfo from "../transformer/transportInfo.js";
import voyageInfo from "../transformer/voyageInfo.js";
import { saveLogs } from "../utils/utils.js";

const manifestProcessor = async (d: any) => {
  try {
    const generalInfoManifest = d.airmanifest;
    var gInfo;
    var tInfo;
    var vInfo;
    var vCargo;
    var cInfo;
    if (generalInfoManifest.General_Info) {
      gInfo = await generalInfoProcess(generalInfoManifest.General_Info);

      tInfo = await transportInfo({
        ...generalInfoManifest.General_Info.Transport_segment,
        ...generalInfoManifest.General_Info,
      });
      vInfo = await voyageInfo({
        ...generalInfoManifest.General_Info.Transport_segment,
        ...generalInfoManifest.General_Info,
      });
      vCargo = await cargoInfo({
        ...generalInfoManifest.General_Info,
        ...generalInfoManifest.General_Info.Tonnage_segment,
      });
      cInfo = await carrierInfo(
        generalInfoManifest.General_Info.Carrier_segment,
      );
      // vInfo await
    }
  } catch (err: any) {
    console.log(err);
    saveLogs("ERROR", err.message, new Date().toISOString());
  }
};

export default manifestProcessor;
