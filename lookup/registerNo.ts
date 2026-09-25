import { lookupReturnInterface } from "../types/generalTypes.js";

export const hanleChangeRegisterNumber = (d: string): lookupReturnInterface => {
  if (!d) {
    return { error: true, data: { registryNo: "" } };
  } else if (d.substring(0, 2) === "7CA")
    return { error: false, data: { registryNo: d.replace("7CA", "JJA") } };
  else return { error: false, data: { registryNo: d } };
};
