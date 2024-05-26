-- Drop triggers
DROP TRIGGER user_trigger;
DROP TRIGGER shop_request_trigger;
DROP TRIGGER shop_trigger;
DROP TRIGGER product_trigger;
DROP TRIGGER advertisement_trigger;
DROP TRIGGER wishlist_trigger;
DROP TRIGGER cartlist_trigger;
DROP TRIGGER discount_trigger;
DROP TRIGGER orderplace_trigger;
DROP TRIGGER payment_trigger;
DROP TRIGGER report_trigger;
DROP TRIGGER review_trigger;
DROP TRIGGER orderlist_trigger;
DROP TRIGGER collection_trigger;

-- Drop sequences
DROP SEQUENCE user_seq;
DROP SEQUENCE shop_request_seq;
DROP SEQUENCE shop_seq;
DROP SEQUENCE product_seq;
DROP SEQUENCE advertisement_seq;
DROP SEQUENCE wishlist_seq;
DROP SEQUENCE cartlist_seq;
DROP SEQUENCE discount_seq;
DROP SEQUENCE orderplace_seq;
DROP SEQUENCE payment_seq;
DROP SEQUENCE report_seq;
DROP SEQUENCE review_seq;
DROP SEQUENCE orderlist_seq;
DROP SEQUENCE collection_seq;

-- Drop tables
DROP TABLE COLLECTION_SLOT CASCADE CONSTRAINTS;
DROP TABLE ORDERLIST CASCADE CONSTRAINTS;
DROP TABLE REVIEW CASCADE CONSTRAINTS;
DROP TABLE REPORT CASCADE CONSTRAINTS;
DROP TABLE PAYMENT CASCADE CONSTRAINTS;
DROP TABLE ORDERPLACE CASCADE CONSTRAINTS;
DROP TABLE DISCOUNT CASCADE CONSTRAINTS;
DROP TABLE CARTLIST CASCADE CONSTRAINTS;
DROP TABLE WISHLIST CASCADE CONSTRAINTS;
DROP TABLE PRODUCT CASCADE CONSTRAINTS;
DROP TABLE SHOP CASCADE CONSTRAINTS;
DROP TABLE SHOP_REQUEST CASCADE CONSTRAINTS;
DROP TABLE USERS CASCADE CONSTRAINTS;
DROP TABLE ADVERTISEMENT CASCADE CONSTRAINTS;

-- Create sequences
CREATE SEQUENCE user_seq START WITH 1 INCREMENT BY 1 NOCACHE;
CREATE SEQUENCE shop_request_seq START WITH 1 INCREMENT BY 1 NOCACHE;
CREATE SEQUENCE shop_seq START WITH 1 INCREMENT BY 1 NOCACHE;
CREATE SEQUENCE product_seq START WITH 1 INCREMENT BY 1 NOCACHE;
CREATE SEQUENCE advertisement_seq START WITH 1 INCREMENT BY 1 NOCACHE;
CREATE SEQUENCE wishlist_seq START WITH 1 INCREMENT BY 1 NOCACHE;
CREATE SEQUENCE cartlist_seq START WITH 1 INCREMENT BY 1 NOCACHE;
CREATE SEQUENCE discount_seq START WITH 1 INCREMENT BY 1 NOCACHE;
CREATE SEQUENCE orderplace_seq START WITH 1 INCREMENT BY 1 NOCACHE;
CREATE SEQUENCE payment_seq START WITH 1 INCREMENT BY 1 NOCACHE;
CREATE SEQUENCE report_seq START WITH 1 INCREMENT BY 1 NOCACHE;
CREATE SEQUENCE review_seq START WITH 1 INCREMENT BY 1 NOCACHE;
CREATE SEQUENCE orderlist_seq START WITH 1 INCREMENT BY 1 NOCACHE;
CREATE SEQUENCE collection_seq START WITH 1 INCREMENT BY 1 NOCACHE;

-- Create tables
CREATE TABLE USERS (
    user_id NUMBER(5) PRIMARY KEY,
    username VARCHAR2(50),
    user_image VARCHAR2(255),
    dob DATE,
    email VARCHAR2(50) NOT NULL,
    password VARCHAR2(50),
    vcode VARCHAR2(250),
    phone_no VARCHAR2(15),
    gender VARCHAR2(8),
    user_role VARCHAR2(8),
    is_disabled VARCHAR2(15)
);

CREATE TABLE SHOP_REQUEST (
    shop_request_id NUMBER(5) PRIMARY KEY,
    shop_address VARCHAR2(30),
    shop_name VARCHAR2(40),
    shop_contact VARCHAR2(40),
    category VARCHAR2(150),
    shop_description VARCHAR2(50),
    proposal_message VARCHAR2(250),
    is_approved VARCHAR2(10),
    user_id NUMBER(5) REFERENCES USERS(user_id)
);

CREATE TABLE SHOP (
    shop_id NUMBER(5) PRIMARY KEY,
    shop_request_id NUMBER(5) REFERENCES SHOP_REQUEST(shop_request_id)
);

CREATE TABLE PRODUCT (
    product_id NUMBER(5) PRIMARY KEY,
    product_name VARCHAR2(40) NOT NULL UNIQUE,
    product_description VARCHAR2(150),
    product_image VARCHAR2(255),
    quantity_in_stock NUMBER(5),
    price NUMBER(8,2),
    is_disabled VARCHAR2(6),
    unit VARCHAR2(5),
    alergyInformation VARCHAR2(250),
    shop_id NUMBER(5) REFERENCES SHOP(shop_id)
);

CREATE TABLE ADVERTISEMENT (
    advertisement_id NUMBER(5) PRIMARY KEY,
    status VARCHAR2(10),
    start_date DATE,
    end_date DATE,
    is_approved VARCHAR2(6),
    product_id NUMBER(5) REFERENCES PRODUCT(product_id)
);

CREATE TABLE WISHLIST (
    wishlist_id NUMBER(5) PRIMARY KEY,
    added_at DATE,
    user_id NUMBER(5) REFERENCES USERS(user_id),
    product_id NUMBER(5) REFERENCES PRODUCT(product_id)
);

CREATE TABLE CARTLIST (
    cartlist_id NUMBER(5) PRIMARY KEY,
    quantity NUMBER(5) NOT NULL,
    product_id NUMBER(5) REFERENCES PRODUCT(product_id),
    user_id NUMBER(5) REFERENCES USERS(user_id)
);

CREATE TABLE DISCOUNT (
    discount_id NUMBER(5) PRIMARY KEY,
    discount_rate NUMBER(5,2) NOT NULL,
    start_date DATE,
    end_date DATE,
    product_id NUMBER(5) REFERENCES PRODUCT(product_id)
);

CREATE TABLE ORDERPLACE (
    orderplace_id NUMBER(5) PRIMARY KEY,
    payment_Status VARCHAR2(15),
    day VARCHAR2(15),
    timeslot VARCHAR2(20),
    date_of_collection date,
    subtotal NUMBER(5,2),
    user_id NUMBER(5) REFERENCES USERS(user_id)
);

CREATE TABLE PAYMENT (
    payment_id NUMBER(5) PRIMARY KEY,
    mode_detail VARCHAR2(20),
    orderplace_id NUMBER(5) REFERENCES ORDERPLACE(orderplace_id)
);

CREATE TABLE REPORT (
    report_id NUMBER(5) PRIMARY KEY,
    payment_id NUMBER(5) REFERENCES PAYMENT(payment_id),
    user_id NUMBER(5) REFERENCES USERS(user_id)
);

CREATE TABLE REVIEW (
    review_id NUMBER(5) PRIMARY KEY,
    message VARCHAR2(150),
    no_of_stars NUMBER(5) NOT NULL,
    product_id NUMBER(5) REFERENCES PRODUCT(product_id),
    user_id NUMBER(5) REFERENCES USERS(user_id)
);

CREATE TABLE ORDERLIST (
    orderlist_id NUMBER(5) PRIMARY KEY,
    quantity NUMBER(5) NOT NULL,
    orderplace_id NUMBER(5) REFERENCES ORDERPLACE(orderplace_id),
    product_id NUMBER(5) REFERENCES PRODUCT(product_id)
);

CREATE TABLE COLLECTION_SLOT (
    collection_id NUMBER(5) PRIMARY KEY,
    day VARCHAR2(15),
    timeslot VARCHAR2(20),
    date_of_collection DATE,
    orderplace_id NUMBER(5) REFERENCES ORDERPLACE(orderplace_id)
);

-- Create triggers
CREATE OR REPLACE TRIGGER user_trigger
BEFORE INSERT ON USERS
FOR EACH ROW
BEGIN
    IF :NEW.user_id IS NULL THEN
        :NEW.user_id := user_seq.NEXTVAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER shop_request_trigger
BEFORE INSERT ON SHOP_REQUEST
FOR EACH ROW
BEGIN
    IF :NEW.shop_request_id IS NULL THEN
        :NEW.shop_request_id := shop_request_seq.NEXTVAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER shop_trigger
BEFORE INSERT ON SHOP
FOR EACH ROW
BEGIN
    IF :NEW.shop_id IS NULL THEN
        :NEW.shop_id := shop_seq.NEXTVAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER product_trigger
BEFORE INSERT ON PRODUCT
FOR EACH ROW
BEGIN
    IF :NEW.product_id IS NULL THEN
        :NEW.product_id := product_seq.NEXTVAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER advertisement_trigger
BEFORE INSERT ON ADVERTISEMENT
FOR EACH ROW
BEGIN
    IF :NEW.advertisement_id IS NULL THEN
        :NEW.advertisement_id := advertisement_seq.NEXTVAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER wishlist_trigger
BEFORE INSERT ON WISHLIST
FOR EACH ROW
BEGIN
    IF :NEW.wishlist_id IS NULL THEN
        :NEW.wishlist_id := wishlist_seq.NEXTVAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER cartlist_trigger
BEFORE INSERT ON CARTLIST
FOR EACH ROW
BEGIN
    IF :NEW.cartlist_id IS NULL THEN
        :NEW.cartlist_id := cartlist_seq.NEXTVAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER discount_trigger
BEFORE INSERT ON DISCOUNT
FOR EACH ROW
BEGIN
    IF :NEW.discount_id IS NULL THEN
        :NEW.discount_id := discount_seq.NEXTVAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER orderplace_trigger
BEFORE INSERT ON ORDERPLACE
FOR EACH ROW
BEGIN
    IF :NEW.orderplace_id IS NULL THEN
        :NEW.orderplace_id := orderplace_seq.NEXTVAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER payment_trigger
BEFORE INSERT ON PAYMENT
FOR EACH ROW
BEGIN
    IF :NEW.payment_id IS NULL THEN
        :NEW.payment_id := payment_seq.NEXTVAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER report_trigger
BEFORE INSERT ON REPORT
FOR EACH ROW
BEGIN
    IF :NEW.report_id IS NULL THEN
        :NEW.report_id := report_seq.NEXTVAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER review_trigger
BEFORE INSERT ON REVIEW
FOR EACH ROW
BEGIN
    IF :NEW.review_id IS NULL THEN
        :NEW.review_id := review_seq.NEXTVAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER orderlist_trigger
BEFORE INSERT ON ORDERLIST
FOR EACH ROW
BEGIN
    IF :NEW.orderlist_id IS NULL THEN
        :NEW.orderlist_id := orderlist_seq.NEXTVAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER collection_trigger
BEFORE INSERT ON COLLECTION_SLOT
FOR EACH ROW
BEGIN
    IF :NEW.collection_id IS NULL THEN
        :NEW.collection_id := collection_seq.NEXTVAL;
    END IF;
END;
/







-- Insert 5 records into USERS table
-- INSERT INTO USERS (user_id, username, user_image, dob, email, password, vcode, phone_no, gender, user_role, is_disabled)
INSERT INTO USERS VALUES (user_seq.NEXTVAL, 'Sabin', 'sabin.jpg', TO_DATE('15-05-1995', 'DD-MM-YYYY'), 'ksabin22@tbc.edu.np', 'Password@123', 'vcode123', '1234567891', 'male', 'trader', 'false');
INSERT INTO USERS VALUES(user_seq.NEXTVAL, 'Srijan', 'srijan.jpg', TO_DATE('20-10-1992', 'DD-MM-YYYY'), 'msrijan21@tbc.edu.np', 'Password@123', 'vcode456', '1234567892', 'male', 'trader', 'false');
INSERT INTO USERS VALUES(user_seq.NEXTVAL, 'Rupesh', 'rupesh.jpg', TO_DATE('25-3-1988', 'DD-MM-YYYY'), 'srupesh22@tbc.edu.np', 'Password@123', 'vcode789', '1234567893', 'male', 'trader', 'false');
INSERT INTO USERS VALUES(user_seq.NEXTVAL, 'Rose', 'rose.jpg', TO_DATE('30-7-1997', 'DD-MM-YYYY'), 'lrose21@tbc.edu.np', 'Password@123', 'vcodeabc', '1234567894', 'female', 'trader', 'false');
INSERT INTO USERS VALUES(user_seq.NEXTVAL, 'Aayush', 'aayush.jpg', TO_DATE('05-12-1990', 'DD-MM-YYYY'), 'maayush22@tbc.edu.np', 'Password@123', 'vcodeefg', '1234567895', 'male', 'trader', 'false');

-- Insert 5 records into SHOP_REQUEST table
INSERT INTO SHOP_REQUEST VALUES(shop_request_seq.NEXTVAL, '789 Maple St', 'Meat Masters', '555-4321', 'Butchers', 'Premium quality cuts of meat', 'Your trusted source for the best meats', 'Yes', 1);
INSERT INTO SHOP_REQUEST VALUES(shop_request_seq.NEXTVAL, '123 Birch St', 'Bread Heaven', '555-8765', 'Bakery', 'Artisanal bread and pastries', 'Savor the taste of freshly baked goods', 'Yes', 2);
INSERT INTO SHOP_REQUEST VALUES(shop_request_seq.NEXTVAL, '456 Spruce St', 'Seafood Bounty', '555-6543', 'Fishmonger', 'The freshest catch from the sea', 'Dive into freshness with our seafood', 'Yes', 3);
INSERT INTO SHOP_REQUEST VALUES (shop_request_seq.NEXTVAL, '987 Willow St', 'Deli Gourmet ', '555-7896', 'Delicatessen', 'Exquisite deli meats and cheeses', 'Indulge in gourmet flavors', 'Yes', 4);
INSERT INTO SHOP_REQUEST VALUES(shop_request_seq.NEXTVAL, '321 Cedar St', 'Green Healthy', '555-0123', 'Greengrocer', 'Organic fruits and vegetables', 'Nourish your body with nature''s best', 'Yes', 5);





-- Insert 5 records into SHOP table
-- INSERT INTO SHOP (shop_id, shop_request_id)
INSERT INTO SHOP VALUES(shop_seq.NEXTVAL, 1);
INSERT INTO SHOP VALUES(shop_seq.NEXTVAL, 2);
INSERT INTO SHOP VALUES(shop_seq.NEXTVAL, 3);
INSERT INTO SHOP VALUES(shop_seq.NEXTVAL, 4);
INSERT INTO SHOP VALUES(shop_seq.NEXTVAL, 5);

-- Insert 50 records into PRODUCT table
-- INSERT INTO USERS (user_id, username, user_image, dob, email, password, vcode, phone_no, gender, user_role, is_disabled)
--Butchers
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Ribeye Steak', 'Juicy ribeye steak', 'ribeye_steak.webp', 20, 15.99, 'false', 'Piece', 'Contains beef', 1);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Pork Chops', 'Fresh pork chops', 'pork_chops.jpg', 30, 8.99, 'false', 'Pack', 'Contains pork', 1);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Chicken Breasts', 'Boneless chicken breasts', 'chicken_breasts.jpg', 50, 6.99, 'false', 'Pack', 'Contains poultry', 1);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Lamb Chops', 'Tender lamb chops', 'lamb_chops.jpg', 25, 14.99, 'false', 'Pack', 'Contains lamb', 1);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Ground Beef', 'Lean ground beef', 'ground_beef.jpg', 40, 5.99, 'false', 'Pack', 'Contains beef', 1);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Bacon', 'Crispy bacon strips', 'bacon.webp', 35, 7.49, 'false', 'Pack', 'Contains pork', 1);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Sausages', 'Spicy sausages', 'sausages.webp', 45, 6.99, 'false', 'Pack', 'Contains pork', 1);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Turkey Legs', 'Juicy turkey legs', 'turkey_legs.jpeg', 30, 9.99, 'false', 'Pack', 'Contains poultry', 1);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Veal Cutlets', 'Tender veal cutlets', 'veal_cutlets.jpg', 15, 18.99, 'false', 'Pack', 'Contains veal', 1);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Beef Ribs', 'Meaty beef ribs', 'beef_ribs.jpeg', 20, 13.99, 'false', 'Pack', 'Contains beef', 1);
--Bakery
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Sourdough Bread', 'Crusty sourdough bread', 'sourdough_bread.jpeg', 30, 4.99, 'false', 'Loaf', 'Contains gluten', 2);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Croissant', 'Buttery croissant', 'croissant.jpeg', 50, 2.99, 'false', 'Piece', 'Contains gluten, dairy', 2);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Baguette', 'Fresh French baguette', 'baguette.jpeg', 40, 3.49, 'false', 'Loaf', 'Contains gluten', 2);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Blueberry Muffin', 'Moist blueberry muffin', 'blueberry_muffin.jpg', 60, 1.99, 'false', 'Piece', 'Contains gluten, dairy', 2);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Chocolate Cake', 'Rich chocolate cake', 'chocolate_cake.jpeg', 20, 14.99, 'false', 'Whole', 'Contains gluten, dairy', 2);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Cinnamon Roll', 'Sweet cinnamon roll', 'cinnamon_roll.jpeg', 35, 3.49, 'false', 'Piece', 'Contains gluten, dairy', 2);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Banana Bread', 'Moist banana bread', 'banana_bread.jpeg', 45, 4.49, 'false', 'Loaf', 'Contains gluten, dairy', 2);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Rye Bread', 'Dense rye bread', 'rye_bread.jpeg', 25, 3.99, 'false', 'Loaf', 'Contains gluten', 2);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Cupcake', 'Vanilla cupcake with frosting', 'cupcake.jpg', 50, 2.49, 'false', 'Piece', 'Contains gluten, dairy', 2);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Bagel', 'Chewy bagel', 'bagel.jpeg', 60, 1.49, 'false', 'Piece', 'Contains gluten', 2);
-- Fishmonger
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Anchovies', 'Salted anchovies', 'anchovies.jpg', 50, 6.99, 'false', 'Pack', 'Contains fish', 3);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Crab', 'Fresh crab meat', 'crab.jpg', 30, 12.99, 'false', 'Pack', 'Contains shellfish', 3);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Haddock', 'Fresh haddock fillets', 'haddock.jpg', 40, 8.99, 'false', 'Pack', 'Contains fish', 3);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Octopus', 'Tender octopus', 'octopus.jpg', 25, 14.99, 'false', 'Pack', 'Contains shellfish', 3);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Salmon', 'Fresh salmon fillets', 'salmon.jpg', 60, 10.99, 'false', 'Pack', 'Contains fish', 3);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Sardines', 'Canned sardines', 'sardines.jpg', 70, 3.99, 'false', 'Can', 'Contains fish', 3);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Scallops', 'Fresh scallops', 'scallops.jpg', 35, 15.99, 'false', 'Pack', 'Contains shellfish', 3);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Shrimp', 'Fresh shrimp', 'shrimp.jpg', 50, 12.49, 'false', 'Pack', 'Contains shellfish', 3);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Tuna', 'Fresh tuna steaks', 'tuna.jpg', 45, 11.99, 'false', 'Pack', 'Contains fish', 3);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Mackerel', 'Fresh mackerel', 'mackerel.jpg', 55, 9.99, 'false', 'Pack', 'Contains fish', 3);
--Delicatessen
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Ham', 'Smoked, sliced ham', 'ham.jpg', 50, 5.99, 'false', 'Pack', 'Contains pork', 4);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Salami', 'Italian salami', 'salami.jpg', 40, 6.49, 'false', 'Pack', 'Contains pork', 4);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Cheddar Cheese', 'Aged cheddar cheese', 'cheddar.jpg', 60, 4.99, 'false', 'Block', 'Contains dairy', 4);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Turkey Breast', 'Sliced turkey breast', 'turkey.jpg', 70, 5.49, 'false', 'Pack', 'None', 4);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Roast Beef', 'Sliced roast beef', 'roast_beef.jpg', 30, 7.99, 'false', 'Pack', 'None', 4);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Mozzarella Cheese', 'Fresh mozzarella cheese', 'mozzarella.jpg', 80, 3.99, 'false', 'Block', 'Contains dairy', 4);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Prosciutto', 'Thinly sliced prosciutto', 'prosciutto.jpg', 45, 8.99, 'false', 'Pack', 'Contains pork', 4);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Brie Cheese', 'Creamy brie cheese', 'brie.jpg', 55, 6.49, 'false', 'Wheel', 'Contains dairy', 4);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Pastrami', 'Sliced pastrami', 'pastrami.jpg', 35, 7.49, 'false', 'Pack', 'None', 4);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Gouda Cheese', 'Aged gouda cheese', 'gouda.jpg', 65, 5.99, 'false', 'Block', 'Contains dairy', 4);
--Greengrocer
-- INSERT INTO PRODUCT (product_id, product_name, product_description, product_image, quantity_in_stock, price, is_disabled, unit, alergyInformation, shop_id)
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Apple', 'Fresh, crunchy apples', 'apple.jpg', 100, 1.99, 'false', 'Piece', 'None', 5);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Banana', 'Ripe, yellow bananas', 'banana.jpg', 80, 0.99, 'false', 'Piece', 'None', 5);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Oranges', 'Juicy, sweet oranges', 'orange.jpg', 120, 2.49, 'false', 'Piece', 'None', 5);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Tomatoes', 'Ripe, red tomatoes', 'tomato.jpeg', 90, 1.49, 'false', 'Piece', 'None', 5);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Lettuce', 'Fresh, crisp lettuce', 'lettuce.webp', 70, 1.29, 'false', 'Piece', 'None', 5);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'avocado', 'Fresh, crisp lettuce', 'avocado.jpg', 70, 1.29, 'false', 'Piece', 'None', 5);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Strawberries', 'Sweet, red strawberries', 'strawberry.jpg', 150, 3.99, 'false', 'Pack', 'None', 5);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Blueberries', 'Fresh, juicy blueberries', 'blueberry.jpg', 200, 4.49, 'false', 'Pack', 'None', 5);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Carrot', 'Crunchy, orange carrots', 'carrot.jpg', 100, 1.99, 'false', 'Bunch', 'None', 5);
INSERT INTO PRODUCT VALUES(product_seq.NEXTVAL, 'Broccoli', 'Fresh, green broccoli', 'broccoli.jpg', 75, 2.99, 'false', 'Piece', 'None', 5);


                                -- Insert 5 records into ADVERTISEMENT table
-- INSERT INTO ADVERTISEMENT (advertisement_id, status, start_date, end_date, is_approved, product_id)
INSERT INTO ADVERTISEMENT VALUES(advertisement_seq.NEXTVAL, 'Active', TO_DATE('2023-01-01', 'YYYY-MM-DD'), TO_DATE('2024-05-28', 'YYYY-MM-DD'), 'Yes', 1);
INSERT INTO ADVERTISEMENT VALUES(advertisement_seq.NEXTVAL, 'Inactive', TO_DATE('2023-02-01', 'YYYY-MM-DD'), TO_DATE('2023-06-28', 'YYYY-MM-DD'), 'Yes', 2);
INSERT INTO ADVERTISEMENT VALUES(advertisement_seq.NEXTVAL, 'Active', TO_DATE('2023-03-01', 'YYYY-MM-DD'), TO_DATE('2024-07-31', 'YYYY-MM-DD'), 'Yes', 3);
INSERT INTO ADVERTISEMENT VALUES(advertisement_seq.NEXTVAL, 'Inactive', TO_DATE('2023-04-01', 'YYYY-MM-DD'), TO_DATE('2023-07-30', 'YYYY-MM-DD'), 'Yes', 4);
INSERT INTO ADVERTISEMENT VALUES(advertisement_seq.NEXTVAL, 'Active', TO_DATE('2023-05-01', 'YYYY-MM-DD'), TO_DATE('2024-08-31', 'YYYY-MM-DD'), 'Yes', 5);


-- Insert 5 records into WISHLIST table
--INSERT INTO WISHLIST (wishlist_id, added_at, user_id, product_id)
INSERT INTO WISHLIST VALUES(wishlist_seq.NEXTVAL, SYSDATE, 1, 1);
INSERT INTO WISHLIST VALUES(wishlist_seq.NEXTVAL, SYSDATE, 2, 2);
INSERT INTO WISHLIST VALUES(wishlist_seq.NEXTVAL, SYSDATE, 3, 3);
INSERT INTO WISHLIST VALUES(wishlist_seq.NEXTVAL, SYSDATE, 4, 4);
INSERT INTO WISHLIST VALUES(wishlist_seq.NEXTVAL, SYSDATE, 5, 5);

-- Insert 5 records into CARTLIST table
--INSERT INTO CARTLIST (cartlist_id, quantity, product_id, user_id)
INSERT INTO CARTLIST VALUES(cartlist_seq.NEXTVAL, 1, 1, 1);
INSERT INTO CARTLIST VALUES(cartlist_seq.NEXTVAL, 2, 2, 2);
INSERT INTO CARTLIST VALUES(cartlist_seq.NEXTVAL, 3, 3, 3);
INSERT INTO CARTLIST VALUES(cartlist_seq.NEXTVAL, 4, 4, 4);
INSERT INTO CARTLIST VALUES(cartlist_seq.NEXTVAL, 5, 5, 5);

-- Insert 5 records into DISCOUNT table
--INSERT INTO DISCOUNT (discount_id, discount_rate, start_date, end_date, product_id)
INSERT INTO DISCOUNT VALUES(discount_seq.NEXTVAL, 0.1, TO_DATE('2023-01-01', 'YYYY-MM-DD'), TO_DATE('2023-01-31', 'YYYY-MM-DD'), 1);
INSERT INTO DISCOUNT VALUES(discount_seq.NEXTVAL, 0.2, TO_DATE('2023-02-01', 'YYYY-MM-DD'), TO_DATE('2023-02-28', 'YYYY-MM-DD'), 2);
INSERT INTO DISCOUNT VALUES(discount_seq.NEXTVAL, 0.15, TO_DATE('2023-03-01', 'YYYY-MM-DD'), TO_DATE('2023-03-31', 'YYYY-MM-DD'), 3);
INSERT INTO DISCOUNT VALUES(discount_seq.NEXTVAL, 0.25, TO_DATE('2023-04-01', 'YYYY-MM-DD'), TO_DATE('2023-04-30', 'YYYY-MM-DD'), 4);
INSERT INTO DISCOUNT VALUES(discount_seq.NEXTVAL, 0.3, TO_DATE('2023-05-01', 'YYYY-MM-DD'), TO_DATE('2023-05-31', 'YYYY-MM-DD'), 5);

-- Insert 5 records into ORDERPLACE table
--INSERT INTO ORDERPLACE (orderplace_id, payment_status, day, timeslot, date_of_collection, subtotal, user_id)
INSERT INTO ORDERPLACE VALUES(orderplace_seq.NEXTVAL, 'Paid', 'Wednesday', '10-13', TO_DATE('2023-01-31', 'YYYY-MM-DD'), 10.99, 1);
INSERT INTO ORDERPLACE VALUES(orderplace_seq.NEXTVAL, 'Paid', 'Thursday', '13-16', TO_DATE('2023-02-01', 'YYYY-MM-DD'), 20.49, 2);
INSERT INTO ORDERPLACE VALUES(orderplace_seq.NEXTVAL, 'Paid', 'Friday', '16-19', TO_DATE('2023-03-01', 'YYYY-MM-DD'), 30.99, 3);
INSERT INTO ORDERPLACE VALUES(orderplace_seq.NEXTVAL, 'Paid', 'Wednesday', '10-13', TO_DATE('2023-04-01', 'YYYY-MM-DD'), 40.49, 4);
INSERT INTO ORDERPLACE VALUES(orderplace_seq.NEXTVAL, 'Paid', 'Thursday', '13-16', TO_DATE('2023-05-01', 'YYYY-MM-DD'), 50.99, 5);





-- Insert 5 records into PAYMENT table
--INSERT INTO PAYMENT (payment_id, mode_detail, orderplace_id)
INSERT INTO PAYMENT VALUES(payment_seq.NEXTVAL, 'Credit Card', 1);
INSERT INTO PAYMENT VALUES(payment_seq.NEXTVAL, 'PayPal', 2);
INSERT INTO PAYMENT VALUES(payment_seq.NEXTVAL, 'Cash On Delivery', 3);
INSERT INTO PAYMENT VALUES(payment_seq.NEXTVAL, 'Credit Card', 4);
INSERT INTO PAYMENT VALUES(payment_seq.NEXTVAL, 'PayPal', 5);

-- Insert 5 records into REPORT table
--INSERT INTO REPORT (report_id, payment_id, user_id)
INSERT INTO REPORT VALUES(report_seq.NEXTVAL, 1, 1);
INSERT INTO REPORT VALUES(report_seq.NEXTVAL, 2, 2);
INSERT INTO REPORT VALUES(report_seq.NEXTVAL, 3, 3);
INSERT INTO REPORT VALUES(report_seq.NEXTVAL, 4, 4);
INSERT INTO REPORT VALUES(report_seq.NEXTVAL, 5, 5);

-- Insert 5 records into REVIEW table
--INSERT INTO REVIEW (review_id, message, no_of_stars, product_id, user_id)
INSERT INTO REVIEW VALUES(review_seq.NEXTVAL, 'Amazing quality, very satisfied!', 5,1, 1);
INSERT INTO REVIEW VALUES(review_seq.NEXTVAL, 'Really fresh and tasty, a must-try', 4,12, 2);
INSERT INTO REVIEW VALUES(review_seq.NEXTVAL, 'Great value for the quality', 4,23, 3);
INSERT INTO REVIEW VALUES(review_seq.NEXTVAL, 'Absolutely delicious, highly recommended', 5,34, 4);
INSERT INTO REVIEW VALUES(review_seq.NEXTVAL, 'Top-notch service, definitely coming back', 5,45, 5);


-- Insert 5 records into ORDERLIST table
--INSERT INTO ORDERLIST (orderlist_id, quantity, orderplace_id, product_id)
INSERT INTO ORDERLIST VALUES(orderlist_seq.NEXTVAL, 1, 1, 1);
INSERT INTO ORDERLIST VALUES(orderlist_seq.NEXTVAL, 2, 2, 2);
INSERT INTO ORDERLIST VALUES(orderlist_seq.NEXTVAL, 3, 3, 3);
INSERT INTO ORDERLIST VALUES(orderlist_seq.NEXTVAL, 4, 4, 4);
INSERT INTO ORDERLIST VALUES(orderlist_seq.NEXTVAL, 5, 5, 5);

-- Insert 5 records into COLLECTION_SLOT table
--INSERT INTO COLLECTION_SLOT (collection_id, day, timeslot, date_of_collection, orderplace_id)
INSERT INTO COLLECTION_SLOT VALUES(collection_seq.NEXTVAL, 'Wednesday', '10-13', TO_DATE('2023-01-01', 'YYYY-MM-DD'), 1);
INSERT INTO COLLECTION_SLOT VALUES(collection_seq.NEXTVAL, 'Thursday', '13-16', TO_DATE('2023-02-01', 'YYYY-MM-DD'), 2);
INSERT INTO COLLECTION_SLOT VALUES(collection_seq.NEXTVAL, 'Friday', '16-19', TO_DATE('2023-03-01', 'YYYY-MM-DD'), 3);
INSERT INTO COLLECTION_SLOT VALUES(collection_seq.NEXTVAL, 'Wednesday', '10-13', TO_DATE('2023-04-01', 'YYYY-MM-DD'), 4);
INSERT INTO COLLECTION_SLOT VALUES(collection_seq.NEXTVAL, 'Thursday', '13-16', TO_DATE('2023-05-01', 'YYYY-MM-DD'), 5);

-- Commit the changes
COMMIT;