%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% P04_F7_CloseMotorsAndSensors.m
% 
% Fil nr 7 som kalles i hovedfil. 
%
% Stenger ned koplinger til NXT og sletter bestemte variable
%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

if online  
    %----------------------------------------------------------------
    % slett variable som ikke skal være med i lagret fil
    %----------------------------------------------------------------
    clear online k    

    %----------------------------------------------------------------
    % Stopp motorene (slett de du ikke bruker)
    %----------------------------------------------------------------
    stop(motorA);           % Stopp motorer
    stop(motorB);           % Stopp motorer
    %stop(motorC);           % Stopp motorer

    %-------------------------------------------    ---------------------
    % Lukk kopling til EV3 og styrestikke
    %----------------------------------------------------------------
    clear mylego
    if ismac
        clear joystick
    else
        clear joymex2
    end

end

