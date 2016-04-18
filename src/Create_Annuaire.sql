CREATE TABLE User (
    UID INT(6) NOT NULL AUTO_INCREMENT,
    Nickname VARCHAR(20) NOT NULL,
    Email VARCHAR(20),
    Password VARCHAR(15),
    EntryDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    Admin BIT,
    PRIMARY KEY (UID)
);

CREATE TABLE Establishment (
    EID INT(6) NOT NULL AUTO_INCREMENT,
    EName VARCHAR(20) NOT NULL,
    Street VARCHAR(20),
    HouseNumber INT(5),
    Zip INT(4),
    City VARCHAR(20),
    Longitude INT(5),
    Latitude INT(5),
    Tel VARCHAR(20),
    Site VARCHAR(20),
    UID INT(6),
    EntryDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (EID),
    FOREIGN KEY (UID) REFERENCES User(UID)
);

CREATE TABLE Restaurant (
    EID INT(6) NOT NULL,
    PriceRange INT(3),
    BanquetCapacity INT(3),
    Takeaway BIT,
    Delivery BIT,
    PRIMARY KEY (EID),
    FOREIGN KEY (EID) REFERENCES Establishment(EID)
);

CREATE TABLE RestaurantClosingDays (
    EID INT(6) NOT NULL,
    ClosingDay ENUM('MON', 'TUE', 'WEN', 'THU', 'FRI', 'SAT', 'SUN'),
    Hour ENUM('AM', 'PM'),
    PRIMARY KEY (EID),
    FOREIGN KEY (EID) REFERENCES Establishment(EID)
);

CREATE TABLE Bar (
    EID INT(6) NOT NULL,
    Smoking BIT,
    Snack BIT,
    PRIMARY KEY (EID),
    FOREIGN KEY (EID) REFERENCES Establishment(EID)
);

CREATE TABLE Hotel (
    EID INT(6) NOT NULL,
    Stars INT(1),
    Rooms INT(3),
    StandartPrice INT(3),
    PRIMARY KEY (EID),
    FOREIGN KEY (EID) REFERENCES Establishment(EID)
);

CREATE TABLE Comment (
    CID INT(6) NOT NULL AUTO_INCREMENT,
    UID INT(6),
    EID INT(6),
    EntryDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    Score INT(1),
    Text TEXT,
    PRIMARY KEY (CID),
    FOREIGN KEY (UID) REFERENCES User(UID),
    FOREIGN KEY (EID) REFERENCES Establishment(EID)
);

CREATE TABLE Tag (
    TID INT(6) NOT NULL AUTO_INCREMENT,
    TName VARCHAR(35) NOT NULL,
    PRIMARY KEY (TID)
);

CREATE TABLE EstablishmentTag (
    TID INT(6),
    EID INT(6),
    UID INT(6),
    PRIMARY KEY (TID),
    FOREIGN KEY (TID) REFERENCES Tag(TID),
    FOREIGN KEY (UID) REFERENCES User(UID),
    FOREIGN KEY (EID) REFERENCES Establishment(EID)
);