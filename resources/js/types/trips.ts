export interface Trips {     
    id: string;
    name: string;
    where_address: string;
    date: string;
    time: string;
    status: string;    
}

export interface Trip {
  id: string;
  name: string;
  where_address: string;
  date: string;
  time: string;
  status: string;
  childrens: number;  
  duration: number;
  distance: number;    
  scheduled_wait_where: number;
  scheduled_wait_from: number;
  not_scheduled_wait_where: number;
  not_scheduled_wait_from: number;
  parking_fee: number | string;
  scan_payment: string;
  attendant_income: number | string;
  description: string;
  parking_info: string;  
  media: string;
}

export interface Children {
  name: string;
  url: string;
}
