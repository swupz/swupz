%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% P04_F3_GetNewMeasurement.m
% 
% Leser inn nye data fra NXT og styrestikke 
%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


%---------------------------------------------------
% øker diskret tellevariabel (felles for online=0=1)
%---------------------------------------------------
k=k+1;  


if online
    %------------------------------------------------
    % tid gått siden første måling
    %------------------------------------------------
    Tid(k) = toc;                

    %------------------------------------------------
    % hent ny måling (slett de du ikke bruker)
    %------------------------------------------------
    % myColorSensor
    Lys(k) = double(readLightIntensity(myColorSensor,'reflected')); 
    %------------------------------------------------
    % spør etter nye data fra styrestikke
    % Utvid selv med andre knapper og akser
    %------------------------------------------------
    if ismac
        skalering = 100;       % konvertering fra 1 til 100%
        JoyMainSwitch = button(joystick,1);
%         JoyForover(k) = -skalering*axis(joystick(2));          % 1 frem, -1 bak
%         JoySide(k) = -skalering*axis(joystick, 1); %2^15 X side, -1^15 en x side
    else
        skalering = 100/2^15;  % konvertering fra 2^15 til 100%
        joystick      = joymex2('query',0);
        JoyMainSwitch = joystick.buttons(1);
%         JoyForover(k) = -skalering*double(joystick.axes(2)); % 2^15 frem, -2^15 bak
%         JoySide(k) = -skalering*double(joystick.axes(1)); %2^15 X side, -1^15 en x side
    end
else
    
    %------------------------------------------------
    % online=0 
    % når k er like stor som antall målinger simuleres
    % det at bryter på styrestikke trykkes inn
    %------------------------------------------------
    if k==numel(Lys)
        JoyMainSwitch=1;
    end
%     JoySide(k) = 0;
%     JoyForover(k) = 0;
end
