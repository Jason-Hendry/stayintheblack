

CREATE TABLE payment (
       idpayment INTEGER PRIMARY KEY AUTOINCREMENT,
       idgroup INTEGER,
       payment_date DATE,
       amount REAL,
       deleted BOOLEAN
);

CREATE INDEX "payment_idpayment" ON "payment" ("idpayment");

CREATE TABLE payment_group (
       idgroup INTEGER PRIMARY KEY AUTOINCREMENT,
       amount REAL,
       currency TEXT,
       initial_date DATE,
       termination_date DATE,
       frequency REAL,
       frequency_type TEXT,
       status TEXT,
       deleted BOOLEAN
);

CREATE INDEX "payment_group_idgroup" ON "payment_group" ("idgroup");