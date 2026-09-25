export const manifestHourReturn = (d: string) => {
  if (d)
    return {
      error: false,
      data: { arrivalTimeHours: d.split(":")[0] },
    };
  else return { error: true, data: { arrivalTimeHours: "" } };
};
export const manifestMinutesReturn = (d: string) => {
  if (d)
    return {
      error: false,
      data: { arrivalTimeHours: d.split(":")[1] },
    };
  else return { error: true, data: { arrivalTimeHours: "" } };
};
