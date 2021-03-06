--SELECT c.CAR_ID, c.CAR_REG, c.CAR_BODYTYPE, d.MODEL_NAME, m.MAKE_NAME FROM CAR c, CMODEL d, MAKE m
--WHERE c.MODEL_ID = d.MODEL_ID 
--AND c.MAKE_ID = m.MAKE_ID;

SELECT c.CAR_REG, f.FEATURE_NAME FROM CAR c, FEATURE f, CAR_FEATURE d
WHERE c.CAR_FEATURE_ID = d.CAR_FEATURE_ID
AND f.FEATURE_ID IN (d.FEATURE_ID_1, d.FEATURE_ID_2, d.FEATURE_ID_3, d.FEATURE_ID_4, 
d.FEATURE_ID_5, d.FEATURE_ID_6,d.FEATURE_ID_6, d.FEATURE_ID_7, d.FEATURE_ID_8, d.FEATURE_ID_9, d.FEATURE_ID_10)
ORDER BY c.CAR_REG;

SELECT * FROM FEATURE;