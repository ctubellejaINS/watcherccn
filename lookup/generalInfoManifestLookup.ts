import { getbocOfCode } from "../db/refOfficeClearanceCollection.js";

const manifestReturn = async (where: any) => {
  const r = await getbocOfCode(where);
  if (!r) {
    return { error: true, data: { bocOfcDescription: "" } };
  } else {
    return { error: false, data: { bocOfcDescription: r.name } };
  }
};
export { manifestReturn };
