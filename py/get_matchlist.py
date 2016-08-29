#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
Created on Sun Mar 27 00:07:40 2016

@author: emilyzhang
"""

import urllib, json, time
import sys

#cgitb.enable()
#data = cgi.FieldStorage()

summoner = sys.argv[1]
year = sys.argv[2]
summ_id = sys.argv[3]

#summoner = "maemisaki"
#year = "2016"
#summ_id = 32507897


def get_matchlist(summ_id):
    
    global year
    
    request_name = "https://na.api.pvp.net/api/lol/na/v2.2/matchlist/by-summoner/"+str(summ_id)+"?rankedQueues=TEAM_BUILDER_DRAFT_RANKED_5x5&seasons=SEASON"+year+"&api_key=6a4fae8d-a82c-4fa6-b797-042dbdc2fa72"
    name = json.loads(urllib.urlopen(request_name).read())
    info = name["matches"]
    matches = []

    for match in info:
        matches.append(match["matchId"])
    return matches


"""writes all the match information to a json file."""
def write_to_json(matches, summ_name, summ_id):
    
    global year    
    
    json_data = []
    print year
    with open("../json/SEASON"+year+"/"+str(summ_id)+".json", 'w') as outfile:               
        counter = 1
        for match in matches:
            print "match "+str(counter)+": "+str(match)
            counter+= 1
            time.sleep(0.6)
            request_name = "https://na.api.pvp.net/api/lol/na/v2.2/match/"+str(match)+"?includeTimeline=true&api_key=6a4fae8d-a82c-4fa6-b797-042dbdc2fa72"
            data = json.loads(urllib.urlopen(request_name).read())
            json_data.append(data)            
        json.dump(json_data, outfile, indent=4)

def main():

    matches = get_matchlist(summ_id)
    matches.sort()
    print len(matches)
    write_to_json(matches, summoner, summ_id)


if __name__ == '__main__':
    main()