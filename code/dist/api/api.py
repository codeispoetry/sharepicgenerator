#!/usr/bin/env python
import time, sys, getopt
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.chrome.options import Options


#####################################
# get args from commandline
#####################################
fullCmdArguments = sys.argv
argumentList = fullCmdArguments[1:]
unixOptions = "ht:v"
gnuOptions = ["help", "text=", "verbose"]
try:
    arguments, values = getopt.getopt(argumentList, unixOptions, gnuOptions)
except getopt.error as err:
    print (str(err))
    sys.exit(2)

#default values
text="Hallo"


for currentArgument, currentValue in arguments:
    if currentArgument in ("-v", "--verbose"):
        print ("enabling verbose mode")
    elif currentArgument in ("-h", "--help"):
        print ("displaying help")
    elif currentArgument in ("-t", "--text"):
        #print (("enabling special output mode (%s)") % (currentValue))
        text = currentValue


options = Options()
options.add_argument("--no-sandbox")
options.add_argument("--headless")

driver = webdriver.Chrome('./chromedriver', chrome_options=options)
#driver = webdriver.Chrome('./chromedriver')
driver.get('http://127.0.0.1:80/dist/')

textEl = driver.find_element_by_id('text')
textEl.send_keys(Keys.CONTROL, 'a')
textEl.send_keys( text )

download = driver.find_element_by_id('download')
download.click()

time.sleep(4) # wait for the image to be processed
driver.quit()