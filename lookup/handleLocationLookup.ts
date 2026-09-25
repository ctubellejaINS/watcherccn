import { getDepartureLocation } from "../db/DepartureCollection.js";
import { getDestinationLocation } from "../db/DestinationCollection.js";

export const getLocationDetailsUsingCode = async (d: any) => {
  if (d.Code) {
    const r = await getDepartureLocation({ code: d.Code });
    return {
      error: false,
      data: {
        plDepartureCode: d.Code,
        plDepartureDescription: r ? r.name : "",
      },
    };
  } else
    return {
      error: true,
      data: { plDepartureCode: "", plDepartureDescription: "" },
    };
};

export const getDestinationUsingCode = async (d: any) => {
  if (d.Code) {
    const r = await getDestinationLocation({ code: d.Code });
    return {
      error: false,
      data: {
        plDestinationCode: d.Code,
        plDestinationDescription: r ? r.name : "",
      },
    };
  } else
    return {
      error: true,
      data: { plDestinationCode: "", plDestinationDescription: "" },
    };
};
export const getVoyageLocation = async (d: any) => {
  if (d.Code) {
    const r = await getDepartureLocation({ code: d.Code });
    return {
      error: false,
      data: {
        countryOrgCode: d.Code,
        countryOrg: r ? r.name : "",
      },
    };
  } else
    return {
      error: true,
      data: { countryOrgCode: "", countryOrg: "" },
    };
};
