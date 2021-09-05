How to automate WhatsApp messages programmatically from your computer
Ampofo Amoh - Gyebi
Ampofo Amoh - Gyebi
Follow
Oct 29, 2020 · 13 min read







I was an admin of an organization’s WhatsApp platform. The most important thing the admins did was to wish everyone on their birthday. We were not supposed to miss it. It involved keeping a book (literally) on every member of the organization just so we don’t miss their birthday. I thought of building an App that will do that, just take care of the bookkeeping and also have an alarm system that will inform on who was the celebrant that day. Now I have discovered we could have also sent the messages programmatically from the App. Essentially we could do all with code.
Introduction
We will be using Twilio and the programming language Python to send the messages. It is really to install it, and it has a free tier. It’s used by Blue Apron, Zendesk, American Red Cross, CipherHealth, etc. Twilio has bindings for other programming languages too, check it out on the quickstart page.
Installation
First, you should have python installed since we will be using python. If you don’t have python installed I suggest you head over to python.org and download the latest update for python 3.
Next, we have to install Twilio. In your terminal, do:
pip install twilio
If you don’t have an IDE, basically a good text editor that will help you to develop apps effectively, I recommend using vs code.
These are the only things we will install for now.
Create project folders and files
Create a folder on your computer for the project name it birthday_messages_app. In it create a file name main.py, we will write the code of our app.
Our Procedure
We will need a database to store some data on employees.
We will query that database to see whose birth month and birthday, matches with today’s day and month.
Then we will send that person a WhatsApp message saying how much we appreciate them.
Step 1 : Set up Database
The database we are going to use for our app is a single-file database. But instead of using a file as a database, which has so many bad side-effects, what we will be using is SQLite which has all the pros and none of the cons associated with single file databases. SQLite comes with python, so you won’t need to install a thing.
To use SQLite we will have to import the sqlite3 module in python. Open the main.py file in the birthday_messages_app folder and write the following.
import sqlite3
conn = sqlite3.connect("company_data.db")
cursor = conn.cursor()
conn.close()
In the above code, we import the sqlite3 module, then connect to a single file database known as company_data.db, this file will be created by sqlite3 in case it doesn’t exist, if it exists too it won’t be overwritten. So essentially it connects to a database known as company_data.
A company’s data may include a lot of things; among them is what we want: employee data. That would probably be stored under a table named employees_data. Employees’ data that will be stored by a company include; first-name, last-name, telephone number, date of birth, address, etc. We will only be interested in first-name, telephone number and then date of birth. We will only read that data from the database. Since we are mocking the data, we should create that table and put in some employee data to be able to build our app.
Lets write functions to input that data into our database. Add this to main.py
def employee_data():
    sql = "CREATE TABLE employees_data (first_name, dob, phone)"
    cursor.execute(sql)
    sql = "INSERT INTO employees_data VALUES (?, ?, ?)"
    data = [('John', '10/30/1990', '+1234567890'),
            ('Tim', '10/29/1992', '+1234567890'),
            ('Van', '10/29/2001', '+1234567890'),
            ]
    cursor.executemany(sql, data)
    conn.commit()
The code above creates a table named employees_data with three columns first_name, date of birth(dob) and then phone, then add three rows of employees with these data. Please replace the telephone numbers with a phone number you are currently using with whatsapp for experimental reasons.
Note, in the dob column, the dates are supposed to be arranged to make our system fun to experiment with. So therefore please use the current day for two of them, and then the next day for the other. So if the app was to run forever we would receive two messages today and another tomorrow.
But first we have to run the function since the code is inside a function. Add this line to the bottom of the main.py to run the function
employee_data()
So now in the main.py we should have:
import sqlite3
conn = sqlite3.connect("company_data.db")
cursor = conn.cursor()
def employee_data():
    sql = "CREATE TABLE employees_data (first_name, dob, phone)"
    cursor.execute(sql)
    sql = "INSERT INTO employees_data VALUES (?, ?, ?)"
    data = [('John', '10/30/1990', '+1234567890'),
            ('Tim', '10/29/1992', '+1234567890'),
            ('Van', '10/29/2001', '+1234567890'),
            ]
    cursor.executemany(sql, data)
    conn.commit()

employee_data()
conn.close()
Open your terminal and enter
cd birthday_messages_app
This will navigate your shell into the birthday_messages_app folder.
Next, run the main.py file by entering the following code. This is how we will be running our main.py onwards.
python main.py
If the above code runs without errors, you will have a database named company_data with a table named employees_data with 3 employees’ first-name, date of birth, and telephone numbers
Next is where we start getting into our app creation.
Step 2: Query Database
It’s time to query the database to know whose birthday it is.
Let’s create a function to do that. In the above employee_data function, we didn’t have to create a function, because we were putting static data into a database. The function employee_data is now useless, but we must create a function to query the database since we would be using the returned value in python.
In your main.py file remove the now obsolete line:
employee_data()
Keep the employee_data function, however, for reference
We would be working with time so Add the following lines to the import statements on top of the file:
...
from time import gmtime, strftime
...
Add the check_birthdays function to the bottom of the file:
...
def check_birthdays():
    birthday_people = []
    sql = "SELECT first_name, dob, phone from employees_data"
    cursor.execute(sql)
    birth_list = cursor.fetchall()
    day, month = strftime('%d %m', gmtime()).split(' ')
    for name, date_set, phone in birth_list:
        dates = date_set.split('/')
        if dates[0] == month and dates[1] == day:
            birthday_people.append((name, phone))

    return set(birthday_people)
In the above code, we check the employees_data database table for those whose birth month and birthday match that of our current day and month.
When you add it to your main.py file you should have something like shown below:
from time import gmtime, strftime
import sqlite3
conn = sqlite3.connect("company_data.db")
cursor = conn.cursor()
def employee_data():
    sql = "CREATE TABLE employees_data (first_name, dob, phone)"
    cursor.execute(sql)
    sql = "INSERT INTO employees_data VALUES (?, ?, ?)"
    data = [('John', '10/30/1990', '+1234567890'),
            ('Tim', '10/29/1992', '+1234567890'),
            ('Van', '10/29/2001', '+1234567890'),
            ]
    cursor.executemany(sql, data)
    conn.commit()
def check_birthdays():
    birthday_people = []
    sql = "SELECT first_name, dob, phone from employees_data"
    cursor.execute(sql)
    birth_list = cursor.fetchall()
    day, month = strftime('%d %m', gmtime()).split(' ')
    for name, date_set, phone in birth_list:
        dates = date_set.split('/')
        if dates[0] == month and dates[1] == day:
            birthday_people.append((name, phone))

    return set(birthday_people)

conn.close()
You can experiment with what the check_birthdays function returns. But we won’t run it that way when we run the application so we haven’t called it yet.
Next, we would want a function that gets the people whose birthday it is from the check_birthdays function, then send messages by using another function to each one of them. I prefer to call the function main since it will be the main caller. Don’t get annoyed you can call it any name you want.
So in your main.py add the main function to the bottom of the file:
def main():
    birthday_people = check_birthdays()
    send_messages(birthday_people)
You can see from the above code that we will have to create a function by name send_messages and use that to send our messages to those people.
The send_messages function will be that which will send the messages to those individuals.
To send those messages, we will have to use Twilio, remember we installed it, but to send WhatsApp messages we would need to signup for Twilio. I don’t believe there are other ways to do this, for example by using WhatsApp API directly, the only way out is by using Twilio, so let’s sign up for Twilio free trial, which is essentially Twilio forever with restrictions.
Step 3: Signup
We could use a free Twilio number and request WhatsApp registration with that but that may take days. So let’s use the sandbox version, which essentially gives us a WhatsApp business account we can use, but you have to re-open since it closes every 24-hours. Don’t get me, let’s get into it.
Sign Up for twilio
Head over to Twilio to register for Twilio, it should be really easy, when you are done, you should be redirected or you should head over to https://www.twilio.com/console.
You should see something like this:

You will need the ACCOUNT SID and the AUTH TOKEN. You will reveal your AUTH TOKEN by clicking on the show button. Copy the two or keep the window open.
For the next step, you should have a device with Whatsapp installed on it.
Head over to https://www.twilio.com/console/sms/whatsapp/sandbox/ where you should find the sandbox we will be using. Activate the sandbox by selecting one of the numbers to use. You will have to send a join {keyword} message to that number to activate.

Now let’s search for an image we can use as a media to send the person. Use this image I borrowed from the net over here.
Now, let’s head back to our app.
Step 4: Send the messages
In our main.py import twilio
...
import sqlite3
from twilio.rest import Client
...
then create the send_messages function. You will need to replace the account_sid, and auth_token with your ACCOUNT SID and AUTH TOKEN from the Twilio console respectively.
If you do not like the provided birthday_cover image, feel free to use another one from the internet.
...
def send_messages(people):
    account_sid = 'AXXXXXXXXXXXXXXXXXXXXXXXXXX'
    auth_token = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
    client = Client(account_sid, auth_token)
    birthday_cover = "https://karaspartyideas.com/wp-content/uploads/2019/04/Chic-Pastel-Dino-Party-via-Karas-Party-Ideas-KarasPartyIdeas.com_.png"
    for name, phone in people:
        msg = f"Happy birthday {name}."
        msg += " We at good Company celebrate you!"
        message = client.messages.create(
            media_url=[birthday_cover],
            from_="whatsapp:+14155238886",
            body=msg,
            to=f"whatsapp:{phone}"
        )
    return True
In the above code, we set variables to hold our ACCOUNT SID and AUTH TOKEN, please change the XXX to reflect your values, we will need that to make a successful call to Twilio’s SMS API.
Next, we create an instance of the Client object by passing in the above two values. The birthday cover we will use as media for our message is next.
Next, we loop through the people, so we can send messages to multiple birthday celebrants if they are multiple.
Next, we create a msg variable to hold a customized message with the person’s name on two lines, to conform to PEP8.
Next, we finally make that call to the API using the client.messages.create a function from twilio.rest module. We pass in the media_url, from_, body, and to variables.
media_url: is a list containing our chosen cover image
from_: is the number provided in the sandbox. It can also be your free Twilio number, and should be in the format “whatsapp:+012345678911”
body: is the body of the message
to: is the whatsapp number with which you joined the sandbox. It should be in the format “whatsapp:+012345678911”
Next we return True on the function that’s all.
Now add this line to the bottom of the main.py file to run the main function
main()
So now the main.py file should look something like this with the XXX replaced:
from time import gmtime, strftime
import sqlite3
from twilio.rest import Client
conn = sqlite3.connect("company_data.db")
cursor = conn.cursor()
def employee_data():
    sql = "CREATE TABLE employees_data (first_name, dob, phone)"
    cursor.execute(sql)
    sql = "INSERT INTO employees_data VALUES (?, ?, ?)"
    data = [('John', '10/30/1990', '+1234567890'),
            ('Tim', '10/29/1992', '+1234567890'),
            ('Van', '10/29/2001', '+1234567890'),
            ]
    cursor.executemany(sql, data)
    conn.commit()
def check_birthdays():
    birthday_people = []
    sql = "SELECT first_name, dob, phone from employees_data"
    cursor.execute(sql)
    birth_list = cursor.fetchall()
    day, month = strftime('%d %m', gmtime()).split(' ')
    for name, date_set, phone in birth_list:
        dates = date_set.split('/')
        if dates[0] == month and dates[1] == day:
            birthday_people.append((name, phone))

    return set(birthday_people)
def send_messages(people):
    account_sid = 'AXXXXXXXXXXXXXXXXXXXXXXXXXX'
    auth_token = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
    client = Client(account_sid, auth_token)
    birthday_cover = "https://karaspartyideas.com/wp-content/uploads/2019/04/Chic-Pastel-Dino-Party-via-Karas-Party-Ideas-KarasPartyIdeas.com_.png"
    for name, phone in people:
        msg = f"Happy birthday {name}."
        msg += " We at good Company celebrate you!"
        message = client.messages.create(
            media_url=[birthday_cover],
            from_="whatsapp:+14155238886",
            body=msg,
            to=f"whatsapp:{phone}"
        )
    return True
def main():
    birthday_people = check_birthdays()
    send_messages(birthday_people)

main()
conn.close()
Now open up the Terminal and run the main.py file. You should have internet access to send this. Enter the following into your terminal
python main.py
Hurray!!! You should receive a very beautiful media message on your Whatsapp. Something similar to this:

Hurray!!!
You can end the tutorial here or you may choose to be a ninja.
Bonus: Time loop system
From our current main.py file, we could just run the main function to check for birthdays and send messages to them, but I prefer we have a time checking system, such that we only run this app once, but it sends messages every day to the birthday celebrant for that day, without we calling it again.
Because we are going to use the sleep function from the time module update your time import statement as:
from time import gmtime, strftime, sleep
Let’s rewrite our main function as this:
def main():
    while True:
        if not_wished_today():
            birthday_people = check_birthdays()
            if send_messages(birthday_people):
                update_last_wished()
        else:
            sleep(3600)
The above code uses a while loop that runs forever. It then checks if we have wished people today if we have it sleeps for 3600 seconds(1 hour) and checks again just so we don’t miss the struck of midnight. If we haven’t wished, we check for celebrants and send the messages and after we are done with sending the messages, we update the date when we last wished people.
We will need a data store to store when last we wished people. Let’s create a database table for that.
In the main.py file create a function birthday_sys
def birthday_sys():
    sql = "CREATE TABLE birthday_sys (last_wished)"
    cursor.execute(sql)
    sql = "INSERT INTO birthday_sys VALUES ('0 0')"
    cursor.execute(sql)
    conn.commit()
The above code when run will create a table birthday_sys with one column last_wished. It also inserts a string “0 0” to represent no day and no month.
Remove the call to the main function from the bottom of the main.py and add this:
birthday_sys()
So now in your main.py, you should have something like
from time import gmtime, strftime, sleep
import sqlite3
from twilio.rest import Client
conn = sqlite3.connect("company_data.db")
cursor = conn.cursor()
def employee_data():
    sql = "CREATE TABLE employees_data (first_name, dob, phone)"
    cursor.execute(sql)
    sql = "INSERT INTO employees_data VALUES (?, ?, ?)"
    data = [('John', '10/30/1990', '+1234567890'),
            ('Tim', '10/29/1992', '+1234567890'),
            ('Van', '10/29/2001', '+1234567890'),
            ]
    cursor.executemany(sql, data)
    conn.commit()
def check_birthdays():
    birthday_people = []
    sql = "SELECT first_name, dob, phone from employees_data"
    cursor.execute(sql)
    birth_list = cursor.fetchall()
    day, month = strftime('%d %m', gmtime()).split(' ')
    for name, date_set, phone in birth_list:
        dates = date_set.split('/')
        if dates[0] == month and dates[1] == day:
            birthday_people.append((name, phone))

    return set(birthday_people)
def send_messages(people):
    account_sid = 'AXXXXXXXXXXXXXXXXXXXXXXXXXX'
    auth_token = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
    client = Client(account_sid, auth_token)
    birthday_cover = "https://karaspartyideas.com/wp-content/uploads/2019/04/Chic-Pastel-Dino-Party-via-Karas-Party-Ideas-KarasPartyIdeas.com_.png"
    for name, phone in people:
        msg = f"Happy birthday {name}."
        msg += " We at good Company celebrate you!"
        message = client.messages.create(
            media_url=[birthday_cover],
            from_="whatsapp:+14155238886",
            body=msg,
            to=f"whatsapp:{phone}"
        )
    return True
def birthday_sys():
    sql = "CREATE TABLE birthday_sys (last_wished)"
    cursor.execute(sql)
    sql = "INSERT INTO birthday_sys VALUES ('0 0')"
    cursor.execute(sql)
    conn.commit()
def main():
    while True:
        if not_wished_today():
            birthday_people = check_birthdays()
            if send_messages(birthday_people):
                update_last_wished()
        else:
            sleep(3600)
birthday_sys()
conn.close()
Run the app from python and this should get you the birthday_sys table.
Now lets write the not_wished_today function
def not_wished_today():
    sql = "SELECT * FROM birthday_sys"
    cursor.execute(sql)
    last_wished = cursor.fetchone()[0]
    curr_time = strftime('%d %m', gmtime())
    if last_wished != curr_time:
        return True
    else:
        return False
The above code gets the last wished from the birthday_sys table and verify with our current date to see if the dates are the same. If they are not, then we haven’t wished anyone that day.
Finally lets also write the update_last_wished function
def update_last_wished():
    curr_time = strftime('%d %m', gmtime())
    sql = f"UPDATE birthday_sys SET last_wished='{curr_time}'"
    cursor.execute(sql)
    conn.commit()
The above code will update the last_wished column to hold the current day and month
Now all is done. Add the main function call to the main.py
main()
So finally the main.py file should look like this, with XXX values changed:
from time import gmtime, strftime, sleep
import sqlite3
from twilio.rest import Client
conn = sqlite3.connect("company_data.db")
cursor = conn.cursor()
def employee_data():
    sql = "CREATE TABLE employees_data (first_name, dob, phone)"
    cursor.execute(sql)
    sql = "INSERT INTO employees_data VALUES (?, ?, ?)"
    data = [('John', '10/30/1990', '+1234567890'),
            ('Tim', '10/29/1992', '+1234567890'),
            ('Van', '10/29/2001', '+1234567890'),
            ]
    cursor.executemany(sql, data)
    conn.commit()
def check_birthdays():
    birthday_people = []
    sql = "SELECT first_name, dob, phone from employees_data"
    cursor.execute(sql)
    birth_list = cursor.fetchall()
    day, month = strftime('%d %m', gmtime()).split(' ')
    for name, date_set, phone in birth_list:
        dates = date_set.split('/')
        if dates[0] == month and dates[1] == day:
            birthday_people.append((name, phone))
    return set(birthday_people)
def send_messages(people):
    account_sid = 'AXXXXXXXXXXXXXXXXXXXXXXXXXX'
    auth_token = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
    client = Client(account_sid, auth_token)
    birthday_cover = "https://karaspartyideas.com/wp-content/uploads/2019/04/Chic-Pastel-Dino-Party-via-Karas-Party-Ideas-KarasPartyIdeas.com_.png"
    for name, phone in people:
        msg = f"Happy birthday {name}."
        msg += " We at good Company celebrate you!"
        message = client.messages.create(
            media_url=[birthday_cover],
            from_="whatsapp:+14155238886",
            body=msg,
            to=f"whatsapp:{phone}"
        )
    return True
def birthday_sys():
    sql = "CREATE TABLE birthday_sys (last_wished)"
    cursor.execute(sql)
    sql = "INSERT INTO birthday_sys VALUES ('0 0')"
    cursor.execute(sql)
    conn.commit()
def not_wished_today():
    sql = "SELECT * FROM birthday_sys"
    cursor.execute(sql)
    last_wished = cursor.fetchone()[0]
    curr_time = strftime('%d %m', gmtime())
    if last_wished != curr_time:
        return True
    else:
        return False
def update_last_wished():
    curr_time = strftime('%d %m', gmtime())
    sql = f"UPDATE birthday_sys SET last_wished='{curr_time}'"
    cursor.execute(sql)
    conn.commit()
def main():
    while True:
        if not_wished_today():
            birthday_people = check_birthdays()
            if send_messages(birthday_people):
                update_last_wished()
        else:
            sleep(3600)
main()
conn.close()
Please for this, I recommend you open a seperate terminal. Navigate to the birthday_messages_app folder
cd birthday_messages_app
And then run the main.py
python main.py
You should see one message at first, and if you keep the terminal open until the next day at 12 midnight the next day, you should receive another message (according to your database), only then should you close the terminal, right? :)