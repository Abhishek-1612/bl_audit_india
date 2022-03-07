INSERT INTO BL_AUDIT_QUESTION VALUES (16,'Reviewed','Reviewed',1,    16,    1,    0    ,SYSDATE,    10,'LEAP',    3,    0    ,0,    'Reviewed');

INSERT INTO BL_AUDIT_QUESTION VALUES (17,'Deletion','Deletion',1,    17,    1,    0    ,SYSDATE,    10,'LEAP',    3,    0    ,0,    'Deletion');

INSERT INTO BL_AUDIT_QUESTION VALUES (18,'Reposting','Reposting',1,    18,    1,    0    ,SYSDATE,    10,'LEAP',    3,    0    ,0,    'Reposting');


OPTIONS*******************************************************



insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 115,16,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;


insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 116,16,'Title Review-Fail','Title Review-Fail',BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;



insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 117,16,'Search Keyword Review-Fail','Search Keyword Review-Fail',BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;


insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 118,16,'MCAT review-Fail','MCAT review-Fail',BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;



insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 119,16,'Description Review-Fail','Description Review-Fail',BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;



insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 120,16,'ISQ Review-Fail','ISQ Review-Fail',BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;


insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 121,16,'Reposting Required-Fail','Reposting Required-Fail',BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;



insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 122,16,'Feedback-Wrong disposition selected as per changes made','Feedback-Wrong disposition selected as per changes made',BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;


*************************
Quetion 17

insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 123,17,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;



insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 124,17,'Correct Lead Deletion-Fail','Correct Lead Deletion-Fail',BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;


insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 125,17,'Wrong deletion disposition selected-Fail','Wrong deletion disposition selected-Fail',BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;

insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 126,17,'Reposting required but deleted-Fail','Reposting required but deleted-Fail',BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;

insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 127,17,'Feedback','Feedback',BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;

*************************
Quetion 18 

insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 128,18,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;



insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 129,18,'Reposting not required-Fail','Reposting not required-Fail',BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;


insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 130,18,'Wrong Reposting Disposition Selection-Fail','Wrong Reposting Disposition Selection-Fail',BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;

insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 131,18,'Deletion required but Reposted-Fail','Deletion required but Reposted-Fail',BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;

insert into BL_AUDIT_QUES_OPT (BL_AUDIT_QUES_OPT_ID ,FK_QUESTION_ID,BL_AUDIT_QUES_OPT_DESC,BL_AUDIT_QUES_OPT_LARGE_DESC,BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS) select 132,18,'Feedback','Feedback',BL_AUDIT_QUES_OPT_STATUS,    
BL_AUDIT_QUES_OPT_PRIORITY,BL_AUDIT_QUES_OPT_MOD_DATE,BL_AUDIT_QUES_OPT_CORRECT_ANS from BL_AUDIT_QUES_OPT where  BL_AUDIT_QUES_OPT_ID=1;