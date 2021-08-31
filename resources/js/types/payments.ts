export interface Payments {
  id: string;
  pay_date: string;
  amount: number;
  spstatus: string;
}

export interface Payment {
  id: string;
  pay_date: string;
  pay_type: string;
  amount: number;
  spstatus: string;
  attendanta_signature: string;
  dispute_reason: string;
}