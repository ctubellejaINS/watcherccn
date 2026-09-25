import moment from "moment";
import { handleError, handleLoopAndGetData, saveLogs } from "../utils/utils.js";
import { manifestReturn } from "../lookup/generalInfoManifestLookup.js";
import {
  manifestHourReturn,
  manifestMinutesReturn,
} from "../lookup/handleTimeLookup.js";
import {
  getDestinationUsingCode,
  getLocationDetailsUsingCode,
} from "../lookup/handleLocationLookup.js";
import { applNoGen } from "../lookup/applNo.js";
import { hanleChangeRegisterNumber } from "../lookup/registerNo.js";

const generalInfoProcess = async (d: any) => {
  try {
    saveLogs(
      `INFO`,
      `Starting manifestInfo processing...`,
      new Date().toISOString(),
    );
    var generalInfoManifest: any = {
      applNo: [applNoGen],
      Registry_number: [hanleChangeRegisterNumber],
      hala: ["hala"],
      Customs_office_segment: [
        async (d: string) => {
          return await manifestReturn({ code: d });
        },
        "bocOfcCode",
      ], //<-- first code here
      Last_Date_Departure: ["dischargeDate"],
      Date_of_arrival: ["arrivalDate"],
      Time_of_arrival: [manifestHourReturn, manifestMinutesReturn],
      Departure_location: [getLocationDetailsUsingCode],
      Destination_location: [getDestinationUsingCode],
    };
    return await handleLoopAndGetData(generalInfoManifest, d);
  } catch (err: any) {
    throw new Error(err.message);
  } finally {
    saveLogs(
      `INFO`,
      `Finished processing manifestInfo.`,
      new Date().toISOString(),
    );
  }
};

export default generalInfoProcess;
