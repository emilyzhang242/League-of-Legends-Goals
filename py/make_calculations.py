#!/usr/bin/env python
# -*- coding: utf-8 -*-
"""
Created on Thu Dec 31 14:39:24 2015

@author: emilyzhang
"""

"""Global Variables"""

import json
import varcalc
import sys

summ_id = sys.argv[1];
year = sys.argv[2];

#summ_id = 37312284
#year = "2016"

current_keys = []
current_values = []

"""Variables specific to calculating actual before 20/after 20 stats"""
#The allowance is made bc timestamp might not be at exactly 20 min

MIN_20 = 20*60*1000

NUM_WINS = 0.0
NUM_LOSSES = 0.0

MAX_KILLS_PRE_20_WIN=0.0
MIN_KILLS_PRE_20_WIN=100
KILL_PRE_20_WIN = 0.0
MAX_ASSIST_PRE_20_WIN=0.0
MIN_ASSIST_PRE_20_WIN=100
ASSIST_PRE_20_WIN = 0.0
MAX_DEATH_PRE_20_WIN=0.0
MIN_DEATH_PRE_20_WIN=100
DEATH_PRE_20_WIN  = 0.0
MAX_WARDS_PLACED_WIN=0.0
MIN_WARDS_PLACED_WIN=100
WARDS_PLACED_WIN = 0.0
MAX_CS_10_WIN=0.0
MIN_CS_10_WIN=1000
CS_10_WIN = 0.0
MAX_CS_20_WIN=0.0
MIN_CS_20_WIN=1000
CS_20_WIN = 0.0
CS_30_WIN = 0.0
MAX_TOTAL_GOLD_WIN=0.0
MIN_TOTAL_GOLD_WIN=100000.0
TOTAL_GOLD_WIN = 0.0

MAX_KILLS_PRE_20_LOSS=0.0
MIN_KILLS_PRE_20_LOSS=100
KILL_PRE_20_LOSS = 0.0
MAX_ASSIST_PRE_20_LOSS=0.0
MIN_ASSIST_PRE_20_LOSS=100.0
ASSIST_PRE_20_LOSS = 0.0
MAX_DEATH_PRE_20_LOSS=0.0
MIN_DEATH_PRE_20_LOSS=100
DEATH_PRE_20_LOSS = 0.0
MAX_WARDS_PLACED_LOSS=0.0
MIN_WARDS_PLACED_LOSS=100
WARDS_PLACED_LOSS = 0.0
MAX_CS_10_LOSS=0.0
MIN_CS_10_LOSS=1000
CS_10_LOSS = 0.0
MAX_CS_20_LOSS=0.0
MIN_CS_20_LOSS=1000
CS_20_LOSS = 0.0
CS_30_LOSS = 0.0
MAX_TOTAL_GOLD_LOSS=0.0
MIN_TOTAL_GOLD_LOSS=100000
TOTAL_GOLD_LOSS = 0.0

MAX_KILLS_POST_20_WIN=0.0
MIN_KILLS_POST_20_WIN=100
KILL_POST_20_WIN = 0.0
MAX_ASSIST_POST_20_WIN=0.0
MIN_ASSIST_POST_20_WIN=100
ASSIST_POST_20_WIN = 0.0
MAX_DEATH_POST_20_WIN=0.0
MIN_DEATH_POST_20_WIN=100
DEATH_POST_20_WIN = 0.0
MAX_TOTAL_CC_WIN=0.0
MIN_TOTAL_CC_WIN=10000
TOTAL_CC_WIN = 0.0

MAX_KILLS_POST_20_LOSS=0.0
MIN_KILLS_POST_20_LOSS=100
KILL_POST_20_LOSS = 0.0
MAX_ASSIST_POST_20_LOSS=0.0
MIN_ASSIST_POST_20_LOSS=100
ASSIST_POST_20_LOSS = 0.0
MAX_DEATH_POST_20_LOSS=0.0
MIN_DEATH_POST_20_LOSS=100
DEATH_POST_20_LOSS = 0.0
MAX_TOTAL_CC_LOSS=0.0
MIN_TOTAL_CC_LOSS=10000
TOTAL_CC_LOSS = 0.0               


"""Uses the champion ID number to get the champion.
    Returns: a string"""
def get_champ(champ_num):
    
    return varcalc.champ_dict.get(champ_num)

"""Gets the match information from the API using the matchId.
    Returns: a dictionary."""
def get_match_info(match, summ_id):
    
    global stat_info  
    global current_keys
    global current_values
    
    participants = match["participants"]  
    identities = match["participantIdentities"]
    timeframe = ""
    if "timeline" in match.keys():
        timeframe = match["timeline"]
    
    spec_info = {}    
    
    for participant in participants:
        if match_summ(participant["participantId"], summ_id, identities):
            spec_info = participant

    
    #diff dictionaries
    current_keys = []
    current_values = []
    spec_key = ""
    create_dict(spec_info, spec_key)    
    
    gen_dict = dict(zip(current_keys, current_values))
    
    if timeframe != "":
        calculate_table(gen_dict, timeframe, participants)
    

"""Makes all dictionaries into a single level dictionary.
    Doesn't return anything. Changes the global values of 
    current_keys and current_values"""
def create_dict(dic, spec_key):
    global current_keys
    global current_values 
    
    for key in dic:
        if key is not "timeline":
            if type(dic[key]) != dict:
                if spec_key == "":
                    current_keys.append(key)
                    current_values.append(dic[key])
                else:
                    current_keys.append(spec_key+" "+str(key))
                    current_values.append(dic[key])
            else:
                create_dict(dic[key], key)
            

"""This function calculates out the values needed for the global variables
    for the specific stats.
    Returns: nothing"""
def calculate_table(gen_dict, timeframe, part_dict): 
    
    partId = gen_dict["participantId"]         
            
    teams = calc_teammates(gen_dict["teamId"], gen_dict["participantId"], part_dict)  
    
    global NUM_WINS
    global NUM_LOSSES
    
    win = False  
    
    if gen_dict['stats winner'] == True:
        NUM_WINS+=1
        win = True
    else:
        NUM_LOSSES+=1

    global MAX_KILLS_PRE_20_WIN
    global MIN_KILLS_PRE_20_WIN
    global KILL_PRE_20_WIN 
    global MAX_ASSIST_PRE_20_WIN
    global MIN_ASSIST_PRE_20_WIN
    global ASSIST_PRE_20_WIN 
    global MAX_DEATH_PRE_20_WIN
    global MIN_DEATH_PRE_20_WIN
    global DEATH_PRE_20_WIN  
    global MAX_WARDS_PLACED_WIN
    global MIN_WARDS_PLACED_WIN
    global WARDS_PLACED_WIN 
    global MAX_CS_10_WIN
    global MIN_CS_10_WIN
    global CS_10_WIN 
    global MAX_CS_20_WIN
    global MIN_CS_20_WIN
    global CS_20_WIN
    global MAX_TOTAL_GOLD_WIN
    global MIN_TOTAL_GOLD_WIN
    global TOTAL_GOLD_WIN

    global MAX_KILLS_PRE_20_LOSS
    global MIN_KILLS_PRE_20_LOSS
    global KILL_PRE_20_LOSS 
    global MIN_ASSIST_PRE_20_LOSS
    global MAX_ASSIST_PRE_20_LOSS
    global ASSIST_PRE_20_LOSS 
    global MAX_DEATH_PRE_20_LOSS
    global MIN_DEATH_PRE_20_LOSS
    global DEATH_PRE_20_LOSS  
    global MAX_WARDS_PLACED_LOSS
    global MIN_WARDS_PLACED_LOSS
    global WARDS_PLACED_LOSS
    global MAX_CS_10_LOSS
    global MIN_CS_10_LOSS
    global CS_10_LOSS
    global MAX_CS_20_LOSS
    global MIN_CS_20_LOSS
    global CS_20_LOSS
    global MAX_TOTAL_GOLD_LOSS
    global MIN_TOTAL_GOLD_LOSS
    global TOTAL_GOLD_LOSS
    
    if win == True:
        kill_win = search_timeline(timeframe, "CHAMPION_KILL", gen_dict["participantId"], teams[0]) 
        KILL_PRE_20_WIN += kill_win
        MIN_KILLS_PRE_20_WIN=min(MIN_KILLS_PRE_20_WIN,kill_win)
        MAX_KILLS_PRE_20_WIN=max(MAX_KILLS_PRE_20_WIN,kill_win)
        
        assist_win = search_timeline(timeframe, "KILL_ASSIST", gen_dict["participantId"], teams[0]) 
        ASSIST_PRE_20_WIN += assist_win
        MIN_ASSIST_PRE_20_WIN=min(MIN_ASSIST_PRE_20_WIN, assist_win)
        MAX_ASSIST_PRE_20_WIN=max(MAX_ASSIST_PRE_20_WIN, assist_win)
        
        death_win = search_timeline(timeframe, "DEATH", gen_dict["participantId"], teams[0]) 
        DEATH_PRE_20_WIN += death_win
        MIN_DEATH_PRE_20_WIN=min(MIN_DEATH_PRE_20_WIN, death_win)
        MAX_DEATH_PRE_20_WIN=max(MAX_DEATH_PRE_20_WIN, death_win)           
        
        wards_win = search_timeline(timeframe, "WARD_PLACED", gen_dict["participantId"], teams[0]) 
        WARDS_PLACED_WIN += wards_win
        MAX_WARDS_PLACED_WIN=max(MAX_WARDS_PLACED_WIN,wards_win)
        MIN_WARDS_PLACED_WIN=min(MIN_WARDS_PLACED_WIN,wards_win)
        
        try:        
            cs_10 = point_timeline(timeframe, "CS", partId, 10)
            CS_10_WIN += cs_10
            MIN_CS_10_WIN=min(MIN_CS_10_WIN, cs_10)
            MAX_CS_10_WIN=max(MAX_CS_10_WIN,cs_10)
        except:
            CS_10_WIN += CS_10_WIN/NUM_WINS
        try:
            cs_20 = point_timeline(timeframe, "CS", partId, 20)
            CS_20_WIN += cs_20
            MIN_CS_20_WIN=min(MIN_CS_20_WIN, cs_20)
            MAX_CS_20_WIN=max(MAX_CS_20_WIN,cs_20)
        except:
            CS_20_WIN += CS_20_WIN/NUM_WINS
        try:
            total_gold = point_timeline(timeframe, "GOLD", partId, 20)
            TOTAL_GOLD_WIN += total_gold
            MAX_TOTAL_GOLD_WIN=max(MAX_TOTAL_GOLD_WIN, total_gold)
            MIN_TOTAL_GOLD_WIN=min(MIN_TOTAL_GOLD_WIN, total_gold)
        except:
            TOTAL_GOLD_WIN += TOTAL_GOLD_WIN/NUM_WINS

    else:
        
        kill_loss = search_timeline(timeframe, "CHAMPION_KILL", gen_dict["participantId"], teams[0]) 
        KILL_PRE_20_LOSS += kill_loss
        MIN_KILLS_PRE_20_LOSS=min(MIN_KILLS_PRE_20_LOSS,kill_loss)
        MAX_KILLS_PRE_20_LOSS=max(MAX_KILLS_PRE_20_LOSS,kill_loss) 
        
        assist_loss = search_timeline(timeframe, "KILL_ASSIST", gen_dict["participantId"], teams[0]) 
        ASSIST_PRE_20_LOSS += assist_loss
        MIN_ASSIST_PRE_20_LOSS=min(MIN_ASSIST_PRE_20_LOSS, assist_loss)
        MAX_ASSIST_PRE_20_LOSS=max(MAX_ASSIST_PRE_20_LOSS, assist_loss)
        
        death_loss = search_timeline(timeframe, "DEATH", gen_dict["participantId"], teams[0]) 
        DEATH_PRE_20_LOSS += death_loss
        MIN_DEATH_PRE_20_LOSS=min(MIN_DEATH_PRE_20_LOSS, death_loss)
        MAX_DEATH_PRE_20_LOSS=max(MAX_DEATH_PRE_20_LOSS, death_loss)           
        
        wards_loss = search_timeline(timeframe, "WARD_PLACED", gen_dict["participantId"], teams[0]) 
        WARDS_PLACED_LOSS += wards_loss
        MAX_WARDS_PLACED_LOSS=max(MAX_WARDS_PLACED_LOSS,wards_loss)
        MIN_WARDS_PLACED_LOSS=min(MIN_WARDS_PLACED_LOSS,wards_loss)
         
        try:        
            cs_10 = point_timeline(timeframe, "CS", partId, 10)
            CS_10_LOSS += cs_10
            MIN_CS_10_LOSS=min(MIN_CS_10_LOSS, cs_10)
            MAX_CS_10_LOSS=max(MAX_CS_10_LOSS,cs_10)
        except:
            CS_10_LOSS += CS_10_LOSS/NUM_LOSSES
        try:
            cs_20 = point_timeline(timeframe, "CS", partId, 20)
            CS_20_LOSS += cs_20
            MIN_CS_20_LOSS=min(MIN_CS_20_LOSS, cs_20)
            MAX_CS_20_LOSS=max(MAX_CS_20_LOSS,cs_20)
        except:
            CS_20_LOSS += CS_20_LOSS/NUM_LOSSES
        #CS_30_LOSS += point_timeline(timeframe, "CS", partId, 30)
        try:
            total_gold = point_timeline(timeframe, "GOLD", partId, 20)
            TOTAL_GOLD_LOSS += total_gold
            MAX_TOTAL_GOLD_LOSS=max(MAX_TOTAL_GOLD_LOSS, total_gold)
            MIN_TOTAL_GOLD_LOSS=min(MIN_TOTAL_GOLD_LOSS, total_gold)
        except:
            TOTAL_GOLD_LOSS += TOTAL_GOLD_LOSS/NUM_LOSSES        
    
    global MAX_KILLS_POST_20_WIN
    global MIN_KILLS_POST_20_WIN
    global KILL_POST_20_WIN 
    global MAX_ASSIST_POST_20_WIN
    global MIN_ASSIST_POST_20_WIN
    global ASSIST_POST_20_WIN 
    global MAX_DEATH_POST_20_WIN
    global MIN_DEATH_POST_20_WIN
    global DEATH_POST_20_WIN  
    global MAX_TOTAL_CC_WIN
    global MIN_TOTAL_CC_WIN
    global TOTAL_CC_WIN 
    
    global MAX_KILLS_POST_20_LOSS
    global MIN_KILLS_POST_20_LOSS
    global KILL_POST_20_LOSS 
    global MAX_ASSIST_POST_20_LOSS
    global MIN_ASSIST_POST_20_LOSS
    global ASSIST_POST_20_LOSS 
    global MAX_DEATH_POST_20_LOSS
    global MIN_DEATH_POST_20_LOSS
    global DEATH_POST_20_LOSS
    global MAX_TOTAL_CC_LOSS
    global MIN_TOTAL_CC_LOSS
    global TOTAL_CC_LOSS     
    
    if win == True:
        MAX_KILLS_POST_20_WIN=max(MAX_KILLS_POST_20_WIN,gen_dict["stats kills"])
        MIN_KILLS_POST_20_WIN=min(MIN_KILLS_POST_20_WIN,gen_dict["stats kills"])
        KILL_POST_20_WIN += gen_dict["stats kills"]
        MAX_ASSIST_POST_20_WIN=max(MAX_ASSIST_POST_20_WIN,gen_dict["stats assists"])
        MIN_ASSIST_POST_20_WIN=min(MIN_ASSIST_POST_20_WIN,gen_dict["stats assists"])
        ASSIST_POST_20_WIN += gen_dict["stats assists"]
        MAX_DEATH_POST_20_WIN=max(MAX_DEATH_POST_20_WIN,gen_dict["stats deaths"])
        MIN_DEATH_POST_20_WIN=min(MIN_DEATH_POST_20_WIN,gen_dict["stats deaths"])
        DEATH_POST_20_WIN += gen_dict["stats deaths"]
        MAX_TOTAL_CC_WIN=max(MAX_TOTAL_CC_WIN,calc_cc(gen_dict, part_dict))
        MIN_TOTAL_CC_WIN=min(MIN_TOTAL_CC_WIN,calc_cc(gen_dict, part_dict))
        TOTAL_CC_WIN += calc_cc(gen_dict, part_dict)
    else:
        MAX_KILLS_POST_20_LOSS=max(MAX_KILLS_POST_20_LOSS,gen_dict["stats kills"])
        MIN_KILLS_POST_20_LOSS=min(MIN_KILLS_POST_20_LOSS,gen_dict["stats kills"])
        KILL_POST_20_LOSS += gen_dict["stats kills"]
        MAX_ASSIST_POST_20_LOSS=max(MAX_ASSIST_POST_20_LOSS,gen_dict["stats assists"])
        MIN_ASSIST_POST_20_LOSS=min(MIN_ASSIST_POST_20_LOSS,gen_dict["stats assists"])
        ASSIST_POST_20_LOSS += gen_dict["stats assists"]
        MAX_DEATH_POST_20_LOSS=max(MAX_DEATH_POST_20_LOSS,gen_dict["stats deaths"])
        MIN_DEATH_POST_20_LOSS=min(MIN_DEATH_POST_20_LOSS,gen_dict["stats deaths"])
        DEATH_POST_20_LOSS += gen_dict["stats deaths"]
        MAX_TOTAL_CC_LOSS=max(MAX_TOTAL_CC_LOSS,calc_cc(gen_dict, part_dict))
        MIN_TOTAL_CC_LOSS=min(MIN_TOTAL_CC_LOSS,calc_cc(gen_dict, part_dict))
        TOTAL_CC_LOSS += calc_cc(gen_dict, part_dict)


"""Calculates the value at the 20 minute mark on the timeline.
    Returns: int"""
def point_timeline(timeline, event, person, num_time):   
    
    global time_lim_met    
    
    for frame in timeline["frames"]:
        if frame["timestamp"] > num_time*60000 and frame["timestamp"] < (num_time+1)*60000:
            time_lim_met = True            
            if event == "CS":
                minions = frame["participantFrames"][str(person)]["minionsKilled"] 
                + frame["participantFrames"][str(person)]["jungleMinionsKilled"]
                return minions
            elif event == "GOLD":
                return frame["participantFrames"][str(person)]["totalGold"]
            else:
                print "ugh"
                return ""


"""Searches and matches the event type in the timeline
    Returns: int"""
def search_timeline(timeline, event, participant, same_team):
    
    global MIN_20     
    
    event_count = 0
    
    for times in timeline["frames"]:
        if times["timestamp"] < MIN_20 and times["timestamp"] > 60000:
            if "events" in times.keys():
                for frames in times["events"]:
                    if event == "CHAMPION_KILL":
                        if frames["eventType"] == event:
                            if frames["killerId"] == participant:
                                event_count += 1
                    elif event == "KILL_ASSIST":
                        if frames["eventType"] == "CHAMPION_KILL":
                            if frames["victimId"] not in same_team:
                                if "assistingParticipantIds" in frames.keys():
                                    if participant in frames["assistingParticipantIds"]:
                                        event_count += 1 
                    elif event == "DEATH":
                        if frames["eventType"] == "CHAMPION_KILL":
                            if frames["victimId"] == participant:
                                event_count += 1   
                    elif event == "WARD_PLACED":
                        if frames["eventType"] == event:
                            if frames["creatorId"] == participant:
                                event_count += 1
    
    return event_count

"""Calculates the teammates of the participant id given
    Returns: list of lists as [[participant team], [opposing team]]"""
def calc_teammates (teamID, participant, part_dict):
    
    team = [participant]   
    opposing = []
    
    for people in part_dict:
        if people["teamId"] == teamID:
            team.append(people["participantId"])
        else:
            opposing.append(people["participantId"])
    
    teams = [team, opposing]
    return teams
                        
"""Calculates the total amount of CC dealt by the team of the player
    Returns: int"""
def calc_cc(gen_dict, part_dict):
    
    teamID = gen_dict["teamId"]
    cc = 0
    
    for players in part_dict:
        if players["teamId"] == teamID:
            cc += players["stats"]["totalTimeCrowdControlDealt"]
    
    return cc


"""Make sure the summoner ID matches the participant number
    Returns: boolean value"""
def match_summ(participant, summ_id, identities):      
    
    for player in identities:
        if player["participantId"] == participant:
            if player["player"]["summonerId"] == int(summ_id):
                return True
        
    return False        
    

def main():
                
    with open("../json/SEASON"+year+"/"+str(summ_id)+".json",'r') as data_file:
            
        data = json.loads(data_file.read())
        #now dealing with individual match information
        #print "num matches: "+str(len(data))
        count = 0
        for match in data:
        #match, champion, lane
            count += 1
            #print "match number "+str(count)+": "+str(match["matchId"])
            get_match_info(match, summ_id)

        
    global NUM_WINS
    global NUM_LOSSES
    
    global MAX_KILLS_PRE_20_WIN
    global MIN_KILLS_PRE_20_WIN
    global KILL_PRE_20_WIN 
    global MAX_ASSIST_PRE_20_WIN
    global MIN_ASSIST_PRE_20_WIN
    global ASSIST_PRE_20_WIN 
    global MAX_DEATH_PRE_20_WIN
    global MIN_DEATH_PRE_20_WIN
    global DEATH_PRE_20_WIN  
    global MAX_WARDS_PLACED_WIN
    global MIN_WARDS_PLACED_WIN
    global WARDS_PLACED_WIN 
    global MAX_CS_10_WIN
    global MIN_CS_10_WIN
    global CS_10_WIN 
    global MAX_CS_20_WIN
    global MIN_CS_20_WIN
    global CS_20_WIN
    #global CS_30_WIN
    global MAX_TOTAL_GOLD_WIN
    global MIN_TOTAL_GOLD_WIN
    global TOTAL_GOLD_WIN

    global MAX_KILLS_PRE_20_LOSS
    global MIN_KILLS_PRE_20_LOSS
    global KILL_PRE_20_LOSS 
    global MIN_ASSIST_PRE_20_LOSS
    global MAX_ASSIST_PRE_20_LOSS
    global ASSIST_PRE_20_LOSS 
    global MAX_DEATH_PRE_20_LOSS
    global MIN_DEATH_PRE_20_LOSS
    global DEATH_PRE_20_LOSS  
    global MAX_WARDS_PLACED_LOSS
    global MIN_WARDS_PLACED_LOSS
    global WARDS_PLACED_LOSS
    global MAX_CS_10_LOSS
    global MIN_CS_10_LOSS
    global CS_10_LOSS
    global MAX_CS_20_LOSS
    global MIN_CS_20_LOSS
    global CS_20_LOSS
    #global CS_30_LOSS
    global MAX_TOTAL_GOLD_LOSS
    global MIN_TOTAL_GOLD_LOSS
    global TOTAL_GOLD_LOSS
    
    global MAX_KILLS_POST_20_WIN
    global MIN_KILLS_POST_20_WIN
    global KILL_POST_20_WIN 
    global MAX_ASSIST_POST_20_WIN
    global MIN_ASSIST_POST_20_WIN
    global ASSIST_POST_20_WIN 
    global MAX_DEATH_POST_20_WIN
    global MIN_DEATH_POST_20_WIN
    global DEATH_POST_20_WIN  
    global MAX_TOTAL_CC_WIN
    global MIN_TOTAL_CC_WIN
    global TOTAL_CC_WIN 
    
    global MAX_KILLS_POST_20_LOSS
    global MIN_KILLS_POST_20_LOSS
    global KILL_POST_20_LOSS 
    global MAX_ASSIST_POST_20_LOSS
    global MIN_ASSIST_POST_20_LOSS
    global ASSIST_POST_20_LOSS 
    global MAX_DEATH_POST_20_LOSS
    global MIN_DEATH_POST_20_LOSS
    global DEATH_POST_20_LOSS
    global MAX_TOTAL_CC_LOSS
    global MIN_TOTAL_CC_LOSS
    global TOTAL_CC_LOSS 
    
    print NUM_WINS
    print NUM_LOSSES    
    
    #print "WINS PRE 20"
    print KILL_PRE_20_WIN/NUM_WINS 
    print ASSIST_PRE_20_WIN/NUM_WINS
    print DEATH_PRE_20_WIN/NUM_WINS
    print WARDS_PLACED_WIN/NUM_WINS
    print CS_10_WIN/NUM_WINS
    print CS_20_WIN/NUM_WINS
    #print "cs 30 min: "+str(CS_30_WIN/NUM_WINS)
    print TOTAL_GOLD_WIN/NUM_WINS
    
    #print "LOSSES PRE 20"
    print KILL_PRE_20_LOSS/NUM_LOSSES
    print ASSIST_PRE_20_LOSS/NUM_LOSSES
    print DEATH_PRE_20_LOSS/NUM_LOSSES
    print WARDS_PLACED_LOSS/NUM_LOSSES
    print CS_10_LOSS/NUM_LOSSES
    print CS_20_LOSS/NUM_LOSSES
    #print "cs 30 min: "+str(CS_30_LOSS/NUM_LOSSES)
    print TOTAL_GOLD_LOSS/NUM_LOSSES
    
    #print "WINS POST 20"
    print KILL_POST_20_WIN/NUM_WINS
    print ASSIST_POST_20_WIN/NUM_WINS
    print DEATH_POST_20_WIN/NUM_WINS
    print TOTAL_CC_WIN/NUM_WINS
    
    #print "LOSSES POST 20"
    print KILL_POST_20_LOSS/NUM_LOSSES
    print ASSIST_POST_20_LOSS/NUM_LOSSES
    print DEATH_POST_20_LOSS/NUM_LOSSES
    print TOTAL_CC_LOSS/NUM_LOSSES
    
    print MAX_KILLS_PRE_20_WIN
    print MIN_KILLS_PRE_20_WIN
    print MAX_ASSIST_PRE_20_WIN
    print MIN_ASSIST_PRE_20_WIN
    print MAX_DEATH_PRE_20_WIN
    print MIN_DEATH_PRE_20_WIN
    print MAX_WARDS_PLACED_WIN
    print MIN_WARDS_PLACED_WIN
    print MAX_CS_10_WIN
    print MIN_CS_10_WIN
    print MAX_CS_20_WIN
    print MIN_CS_20_WIN
    print MAX_TOTAL_GOLD_WIN
    print MIN_TOTAL_GOLD_WIN
    print MAX_KILLS_PRE_20_LOSS
    print MIN_KILLS_PRE_20_LOSS
    print MAX_ASSIST_PRE_20_LOSS
    print MIN_ASSIST_PRE_20_LOSS
    print MAX_DEATH_PRE_20_LOSS
    print MIN_DEATH_PRE_20_LOSS
    print MAX_WARDS_PLACED_LOSS
    print MIN_WARDS_PLACED_LOSS
    print MAX_CS_10_LOSS
    print MIN_CS_10_LOSS
    print MAX_CS_20_LOSS
    print MIN_CS_20_LOSS
    print MAX_TOTAL_GOLD_LOSS
    print MIN_TOTAL_GOLD_LOSS
    print MAX_KILLS_POST_20_WIN
    print MIN_KILLS_POST_20_WIN
    print MAX_ASSIST_POST_20_WIN
    print MIN_ASSIST_POST_20_WIN
    print MAX_DEATH_POST_20_WIN
    print MIN_DEATH_POST_20_WIN
    print MAX_TOTAL_CC_WIN
    print MIN_TOTAL_CC_WIN
    print MAX_KILLS_POST_20_LOSS
    print MIN_KILLS_POST_20_LOSS
    print MAX_ASSIST_POST_20_LOSS
    print MIN_ASSIST_POST_20_LOSS
    print MAX_DEATH_POST_20_LOSS
    print MIN_DEATH_POST_20_LOSS
    print MAX_TOTAL_CC_LOSS
    print MIN_TOTAL_CC_LOSS
    
if __name__ == '__main__':
    main()
    

