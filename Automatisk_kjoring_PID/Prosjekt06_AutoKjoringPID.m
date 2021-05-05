%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% Prosjekt0X_.....
%
% Hensikten med programmet er ....  
% F�lgende sensorer brukes.....
% Programmet beregner .....
%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

clear; close all               % Alltid lurt � rydde opp f�rst
online=1;                      % Er du koplet til NXT eller ikke?
filename = 'AutoKj�r_beste.mat'; % Navnet p� datafilen n�r online=0. 

P06_F1_Initialize
P06_F2_GetFirstMeasurement
while ~JoyMainSwitch
    P06_F3_GetNewMeasurement
    P06_F5_CalculateAndSetMotorPower
    P06_F4_MathCalculations
end 
P06_F6_PlottData   % kan flyttes til etter while-l�kka

    

ref = Referanse;
middelverdi = my;
forksjellen = abs(Referanse - middelverdi);
standardavvik = sigma(end);
varians = sigma2(end);
kjoretid = Tid(end);
gj_IAE = IAE(end);
gj_ITAE = ITAE(end);
gj_MAE = MAE(end);
gj_TVA = TV_A(end);
gj_TVB = TV_B(end);
gj_Ts = mean(Ts);

fig2 = figure;
figure(fig2);
histogram(Lys);

save(filename, 'fig1', 'fig2', 'ref', 'middelverdi', 'forksjellen', 'standardavvik', 'varians', 'kjoretid', 'gj_IAE', 'gj_ITAE', 'gj_MAE', 'gj_TVA', 'gj_TVB', 'gj_Ts', 'k');


P06_F7_CloseMotorsAndSensors

