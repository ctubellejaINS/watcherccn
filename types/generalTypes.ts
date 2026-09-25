export interface lookupReturnInterface {
  error: boolean;
  data: any;
}
export interface transportInfoInterface {
  transportMode: string;
  transportId: string;
  transportNationality: string;
  transportNationalityCode: string;
  plTransportReg: string;
  transportRegNo: string;
  transportRegDate: string;
}

export interface voyageinfoInterface {
  voyageNo: string;
  countryOrg: string;
  countryOrgCode: string;
  masterInfo: string;
}

export interface cargoInfoInterface {
  numberOfBL: number;
  totalContainers: number;
  grossTonnage: number;
  netTonnage: number;
}

export interface carrierInfoInterface {
  carrierName: string;
  Code: string;
  Address1: string;
  Address2: string;
  Address3: string;
  Address4: string;
}
