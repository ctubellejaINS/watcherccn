import {
  getTransportMode,
  getTransportModeNationality,
  transportRegSegLookup,
} from "../lookup/generalTransportInfoLookup.js";
import { transportInfoInterface } from "../types/generalTypes.js";
import { handleLoopAndGetData, saveLogs } from "../utils/utils.js";

const transportInfo = async (d: any): Promise<transportInfoInterface> => {
  try {
    saveLogs(
      `INFO`,
      `Starting transportInfo processing...`,
      new Date().toISOString(),
    );
    var tranposrtInfoManifest = {
      Mode_of_transport_segment: [getTransportMode],
      FlightNo: ["transportId"],
      Nationality_of_transport_segment: [getTransportModeNationality],

      Transporter_registration_segment: [transportRegSegLookup],
    };

    return (await handleLoopAndGetData(
      tranposrtInfoManifest,
      d,
    )) as transportInfoInterface;
  } catch (err: any) {
    throw new Error(err.message);
  } finally {
    saveLogs(
      `INFO`,
      `Starting transportInfo processing...`,
      new Date().toISOString(),
    );
  }

  var transportInfoManifest: any = {};
};
export default transportInfo;
