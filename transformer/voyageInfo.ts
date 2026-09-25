import { getVoyageLocation } from "../lookup/handleLocationLookup.js";
import { voyageinfoInterface } from "../types/generalTypes.js";
import { handleLoopAndGetData } from "../utils/utils.js";

const voyageInfo = async (d: any): Promise<voyageinfoInterface> => {
  const voyagInfoManifest = {
    FlightNo: ["voyageNo"],
    Departure_location: [getVoyageLocation],
  };
  return await handleLoopAndGetData(voyagInfoManifest, d);
};
export default voyageInfo;
