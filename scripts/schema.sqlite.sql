
CREATE TABLE payment (
       idpayment INTEGER PRIMARY KEY AUTOINCREMENT,
       idusr INTEGER,
       idgroup INTEGER,
       idaccount INTEGER,
       payment_date DATE,
       amount REAL,
       deleted BOOLEAN
);

CREATE TABLE payment_group (
       idgroup INTEGER PRIMARY KEY AUTOINCREMENT,
       idusr INTEGER,
       amount REAL,
       currency TEXT,
       initial_date DATE,
       termination_date DATE,
       frequency REAL,
       frequency_type TEXT,
       status TEXT,
       deleted BOOLEAN
);

CREATE TABLE account_balance (
       idaccount_balance INTEGER PRIMARY KEY AUTOINCREMENT,
       idaccount INTEGER,
       amount REAL,
       balance_timestamp INTEGER
);

CREATE TABLE payment_account (
       idaccount INTEGER PRIMARY KEY AUTOINCREMENT,
       idusr INTEGER,
       account_name TEXT,
       institution TEXT,
       created INTEGER,
       account_type INTEGER
);

CREATE TABLE payment_account_type (
       idaccount_type INTEGER PRIMARY KEY AUTOINCREMENT,
       account_type TEXT,
       account_code TEXT
);

CREATE TABLE usr (
    idusr INTEGER  NOT NULL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(32) NULL,
    real_name VARCHAR(150) NULL
);


CREATE INDEX "payment_idpayment" ON "payment" ("idpayment");
CREATE INDEX "payment_group_idgroup" ON "payment_group" ("idgroup");
