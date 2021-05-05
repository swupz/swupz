%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% P04_F1_Initialize.m
%
% Initialiserer EV3'en med sensorer og motorer, 
% samt styrestikken. Kun aktuelt i online=1.
%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

if online
    
    if ismac 
        %------------------------------------------------
        % Mac-bruker:
        % - Laster først Java-bibliotek til styrestikke
        % - Sletter deretter gamle instanser
        % - Lager nye instanser av EV3 og styrestikke
        %------------------------------------------------
        HebiJoystick.loadLibs();
        clear mylego joystick
        mylego = legoev3('USB');
        joystick = HebiJoystick(1);
    else
        %------------------------------------------------
        % PC-bruker:
        % - Sletter først gamle instanser
        % - Lager nye instanser av EV3 og styrestikke
        %------------------------------------------------
        clear mylego joymex2
        mylego = legoev3('USB');
        joymex2('open',0);
    end
    
    %------------------------------------------------
    % Initialiser sensorer (slett de du ikke bruker)
    %------------------------------------------------
    myColorSensor = colorSensor(mylego);
    %myTouchSensor = touchSensor(mylego);
    %mySonicSensor = sonicSensor(mylego);
    %myGyroSensor  = gyroSensor(mylego);
    
    %------------------------------------------------
    % Dersom du f.eks. skal bruke 2 ultralydsensorer som er
    % montert på inngang 3 og 4, må du spesifisere dette som:
    % mySonicSensor_1 = sonicSensor(mylego,3);
    % mySonicSensor_2 = sonicSensor(mylego,4);
    %------------------------------------------------
        
    %------------------------------------------------
    % Initialiser motorer (slett de du ikke bruker)
    %------------------------------------------------
    motorA = motor(mylego,'A');
    motorA.resetRotation;
    motorB = motor(mylego,'B');
    motorB.resetRotation;
    %motorC = motor(mylego,'C');
    %motorC.resetRotation;

end
