INSERT INTO usr(username,password) VALUES('admin','098f6bcd4621d373cade4e832627b4f6');

INSERT INTO payment_account(account_name,institution,type,idusr) VALUES('Classic','NAB','bank',last_insert_rowid());
INSERT INTO payment_account_bank(idaccount,interest_rate) VALUES(last_insert_rowid(),'0.05');






