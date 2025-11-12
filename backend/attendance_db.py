import mysql.connector

dataBase = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="",  # Change this to your MySQL password
)

# prepare a cursor object
cursorObject = dataBase.cursor()

# Create a database
cursorObject.execute("CREATE DATABASE attendance_db")

print("All Done!")
