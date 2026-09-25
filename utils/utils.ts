import fs from "fs/promises";
import { randomUUID } from "crypto";
export const saveLogs = async (
  status: string,
  message: string,
  date: string,
  id?: string,
) => {
  try {
    console.log(`${id ?? ""}`, status, message, date);
    await fs.appendFile(
      "logs/logs.txt",
      `${id ? `||` : ""} || ${status} || ${message} || ${date} \n`,
      "utf-8",
    );
  } catch (error) {
    console.error("Error saving logs:", error);
  }
};
export const handleError = async (status: string, message: string) => {
  const id = randomUUID();
  const date = new Date().toISOString();
  saveLogs(status, message, date, id);
  return { status, message, date, id };
};
export const delay = async (ms: number) =>
  new Promise((resolve) => setTimeout(resolve, ms));

export const removeString = (
  files: string[],
  stringToRemove: string,
): string[] => {
  return files.map((file) =>
    file.toLowerCase().replace(stringToRemove.toLowerCase(), "").toLowerCase(),
  );
};
export const regexFind = (files: string[]) => {
  return {
    name: {
      $in: files.map((f) => new RegExp(`^${f}`, "i")),
    },
  };
};

export const combineFindData = (paths: string[], collections: any[]) => {
  const result: any[] = [];
  for (const collection of collections) {
    const path = paths.find((path) =>
      path.toLowerCase().includes(collection.name.toLowerCase()),
    );

    if (path) {
      result.push({
        path,
        name: collection.name,
        _id: collection._id,
      });
    }
  }
  return result;
};
export const handleLoopAndGetData = async (d: any, data: any) => {
  const toReturn: any = {
    error: [],
    success: [],
  };
  for (const v of Object.keys(d)) {
    if (data[v]) {
      if (d[v]) {
        for (const vv of d[v]) {
          if (typeof vv === "string") {
            // toReturn.success.push({ [d[v]]: data[v] });

            const d_ = { [vv]: data[v] };
            toReturn.success = [...toReturn.success, d_];
          } else if (typeof vv === "function") {
            const getData = await vv(data[v]);

            if (!getData.error)
              toReturn.success.push(
                ...Object.entries(getData.data).map(([key, value]) => ({
                  [key]: value,
                })),
              );
            else
              toReturn.error.push(
                ...Object.entries(getData.data).map(([key, value]) => ({
                  [key]: value,
                })),
              );
          }
        }
      }
    } else {
      toReturn.error.push({ [v]: "" });
    }
  }

  return toReturn;
};
