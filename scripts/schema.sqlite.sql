
CREATE TABLE payment (
       idpayment INTEGER PRIMARY KEY AUTOINCREMENT,
       idusr INTEGER,
       idgroup INTEGER,
       idaccount INTEGER,
       payment_date INTEGER,
       amount REAL,
       description TEXT,
       created INTEGER,
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

CREATE TABLE payment_account (
       idaccount INTEGER PRIMARY KEY AUTOINCREMENT,
       idusr INTEGER,
       account_name TEXT,
       institution TEXT,
       created INTEGER, 
       deleted BOOLEAN DEFAULT FALSE
);

CREATE TABLE payment_account_balance (
       idaccount_balance INTEGER PRIMARY KEY AUTOINCREMENT,
       idaccount INTEGER,
       balance REAL,
       balance_timestamp INTEGER
);

CREATE TABLE payment_account_bank (
       idaccount INTEGER PRIMARY KEY,
       interest_rate REAL,
       account_fee REAL,
       account_fee_type TEXT
);
CREATE TABLE payment_account_credit_card (
       idaccount INTEGER PRIMARY KEY,
       interest_free_days INTEGER,
       interest_rate REAL,
       transfer_period REAL,
       transfer_rate REAL
);
CREATE TABLE payment_account_loan (
       idaccount INTEGER PRIMARY KEY,
       rate_type TEXT
);

CREATE TABLE usr (
    idusr INTEGER  NOT NULL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(32) NULL,
    real_name VARCHAR(150) NULL
);


CREATE INDEX "payment_idpayment" ON "payment" ("idpayment");
CREATE INDEX "payment_group_idgroup" ON "payment_group" ("idgroup");
