import { getCountry } from "../db/refCountrycollection.js";
import { lookupReturnInterface } from "../types/generalTypes.js";

export const getTransportMode = (d: any): lookupReturnInterface => {
  console.log(!!d.Code);
  if (!!!d.Code) {
    return { error: true, data: { transportMode: "" } };
  } else return { error: false, data: { transportMode: d.Code } };
};

export const getTransportModeNationality = async (
  d: any,
): Promise<lookupReturnInterface> => {
  if (!!!d.Code)
    return {
      error: true,
      data: { transportNationalityCode: "", transportNationality: "" },
    };
  else {
    const r = await getCountry({ code: d.Code });

    return {
      error: false,
      data: {
        transportNationalityCode: d.Code,
        transportNationality: r ? r.description : "",
      },
    };
  }
};
export const transportRegSegLookup = (d: any): lookupReturnInterface => {
  return {
    error: !!!d.Registration_number || !!!d.Registration_date,
    data: {
      transportRegDate: d.Registration_date ?? "",
      transportRegNo: d.Registration_number ?? "",
    },
  };
};
