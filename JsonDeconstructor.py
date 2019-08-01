import simplejson as json
import sqlalchemy as sa
from sqlalchemy import create_engine, Column, Float, String, Integer
from sqlalchemy.orm import  Session
from sqlalchemy.ext.automap import automap_base

def jsonToDict(filename):
    file = open(filename)
    data = json.load(file)
    file.close
    print(data.keys)
    return data

def addColumn(engine, table_name, column):
    column_name = column.compile(dialect=engine.dialect)
    column_type = column.type.compile(engine.dialect)
    engine.execute('ALTER TABLE %s ADD COLUMN %s %s' % (table_name, column_name, column_type))




def matchColumns(dataD):

    # Create ORM model of data base automatically
    Base = automap_base()

    # engine to make connection to sql data base
    # assume we know table name is userData
    engine = create_engine("sqlite:///../testDataBase.db")

    Base.prepare(engine, reflect=True)

    # automap table to class
    userDataClass = Base.classes.userData

    # looping through they keys of JSON object
    for key in dataD.keys():
        # if the key is not already a column
        if not(key in userDataClass.__table__.columns.keys()):

            # Determine data type
            if type(dataD[key]) is float:
                dataType = sa.Float()
            elif type(dataD[key]) is int:
                dataType = sa.Integer()
            elif type(dataD[key]) is str:
                dataType = sa.String()

            column = Column(key, dataType, primary_key=False)
            addColumn(engine,"userData", column)

def insertData(dictD):

    # Create ORM model of data base automatically
    Base = automap_base()

    # engine to make connection to sql data base
    # assume we know table name is userData
    engine = create_engine("sqlite:///../testDataBase.db")

    Base.prepare(engine, reflect=True)

    # automap table to class
    userDataClass = Base.classes.userData

    
    # looping through they keys of JSON object
    dataRow = userDataClass()
    for key in dictD.keys():
        setattr(dataRow,key,dictD[key])
    
    session = Session(engine)

    session.add(dataRow)
    session.commit()






if name == '__main__':
    dataDict = jsonToDict("../data.json")
    matchColumns(dataDict)
    insertData(dataDict)
    print(dataDict.keys())