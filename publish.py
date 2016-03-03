import paho.mqtt.client as mqtt
import time
import sys 

BROKER_PORT = 1883
BROKER_HOST = "127.0.0.1"
KEEPALIVE = 60
TOPIC = 'IoTPlatform' + sys.argv[1]

def on_connect(client, userdata, results):
    print "Connected!!"
    client.subscribe(TOPIC, 0)
    
def on_publish(client, userdata, mid):
    print "Message has been already published."
         
client = mqtt.Client("LacalA", False)
client.on_connect =  on_connect
client.on_publish = on_publish

client.connect(BROKER_HOST, BROKER_PORT, KEEPALIVE)
client.loop_start()

client.publish(TOPIC, sys.argv[2], 1)
time.sleep(0.01)
client.disconnect()