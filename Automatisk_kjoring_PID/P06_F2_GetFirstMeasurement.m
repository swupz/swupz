%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% P04_F2_GetFirstMeasurement.m
% 
% F?r tak i f?rste m?ling fra EV3 med tilh?rende tidspunkt.
% Definerer variable som skal brukes.
%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

if online==1

    %------------------------------------------------
    % setter diskret tellevariabel
    % starter stoppeklokka og setter Tid(1)=0
    %------------------------------------------------
    k=1;
    tic
    Tid(1) = 0;              

    %------------------------------------------------
    % hent f?rste m?ling fra sensorene (slett de du ikke bruker)
    %------------------------------------------------
    % myColorSensor
    Lys(1) = double(readLightIntensity(myColorSensor,'reflected')); 

    % myColorSensor (alternative bruksm?ter)
    % Farge  = readColor(myColorSensor); 
    % Lys(1) = double(readLightIntensity(myColorSensor)); 

    % myTouchSensor
    %Bryter(1)  = double(readTouch(myTouchSensor));   

    % mySonicSensor, avlest i meter
    %Avstand(1) = double(readDistance(mySonicSensor));   

    % myGyroSensor
    %resetRotationAngle(myGyroSensor);
    %GyroAngle(1) = double(readRotationAngle(myGyroSensor));
    %GyroRate(1)  = double(readRotationRate(myGyroSensor));
    

    %------------------------------------------------
    % hent m?ling av motorposisjoner (slett om du ikke bruker)
    %------------------------------------------------
    VinkelPosMotorA(1) = double(motorA.readRotation);
    VinkelPosMotorB(1) = double(motorB.readRotation);
    %VinkelPosMotorC(1) = double(motorC.readRotation);
    
    %------------------------------------------------
    % sp?r etter data fra styrestikke
    % Utvid selv med andre knapper og akser
    %------------------------------------------------
    if ismac
        skalering = 100;       % konvertering fra 1 til 100%
        JoyMainSwitch = button(joystick,1);
%         JoyForover(1) = -skalering*axis(joystick,2);          % 1 frem, -1 bak
%         JoySide(1) = -skalering*axis(joystick, 1); 
    else
        skalering = 100/2^15;  % konvertering fra 2^15 til 100%
        joystick      = joymex2('query',0);
        JoyMainSwitch = joystick.buttons(1);
%         JoyForover(1) = -skalering*double(joystick.axes(2)); % 2^15 frem, -2^15 bak
%         JoySide(1) = -skalering*double(joystick.axes(1));
    end
    
    %-----------------------------------------------------
    % Husk at alle loggede data du har spesifisert over her i 
    % P0X_F2_GetFirstMeasurement.m M? v?re med i save-kommandoen
    % for bruk i ONLINE=0. Et eksempel p? dette er:
    %
    %    save('P0X_DataNavn.mat','Tid','Lys','Avstand',...
    %         'VinkelPosMotorA','JoyForover')
    %
    % Dersom du har jobbet i enten ONLINE=1 eller ONLINE=0, og
    % skal lage figurer av resultatene du har oppn?dd, b?r du 
    % f?rst lukke alle ?pne figurer og deretter lagre HELE workspace: 
    %
    %    close all;
    %    save('P0X_DataNavn_figur1.mat')
    %
    % Dersom du ikke lukker alle ?pne figurer vil disse bli med i 
    % *.mat-filen og den blir dermed veldig stor.
    %-----------------------------------------------------

else
    %------------------------------------------------
    % Dersom online=0 lastes datafil. Dersom datafilen
    % feilaktig innholder online=1 og f.eks. k=1521 
    % fra kj?ringen, settes for sikkerhets skyld
    % online=0 og k=1. 
    % Lat som om styrestikken er i bruk ved ? sette 
    % JoyMainSwitch=0
    %------------------------------------------------
    load(filename)     
    online=0;         
    k=1;              
    JoyMainSwitch=0;
    
end

%----------------------------------------------------
% Definer datavektorer og parametre.
% Denne koden er felles for online=0=1
% 
% NB: Husk at k=2 i neste script P0X_F3_GetNewMeasurement.m. 
% Det er derfor viktig at de datavektorene som ikke skal 
% v?re 0 i f?rste element, initialiseres her!!!
%----------------------------------------------------
Referanse = Lys(1);         
IAE(1) = 0;
ITAE(1) = 0;
TV_A(1) = 0;
TV_B(1) = 0;

PowerA(1) = 0;
PowerB(1) = 0;

I(1) = 0;
e(1) = 0;
e_f(1) = 0;

P(1) = 0;
D(1) = 0;
%-----------------------------------------------------------
% Initialiser figur fig1 (legg til flere figurer etterhvert)
%-----------------------------------------------------------
fig1=figure;

