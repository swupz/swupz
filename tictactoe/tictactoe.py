"""
Tic Tac Toe Player
"""

import copy
import numpy as np

X = "X"
O = "O"
EMPTY = None


def initial_state():
    """
    Returns starting state of the board.
    """
    return [[EMPTY, EMPTY,EMPTY],
            [EMPTY, EMPTY, EMPTY],
            [EMPTY, EMPTY, EMPTY]]


def player(board):
    """
    Returns player who has the next turn on a board.
    """
    count_x = 0
    count_o = 0
    for i in board:
        for j in i:
            if j == "X":
                count_x += 1
            elif j == "O":
                count_o += 1

    if count_x == count_o:
        return X
    else:
        return O


def actions(board):
    """
    Returns set of all possible actions (i, j) available on the board.
    """
    possibilities = set()
    for i in range(3):
        for j in range(3):
            if board[i][j] == EMPTY:
                possibilities.add((i, j))
    return possibilities


def result(board, action):
    """
    Returns the board that results from making move (i, j) on the board.
    """
    used = set()
    for x, i in enumerate(board):
        for y, j in enumerate(i):
            if j == X or j == O:
                used.add((x, y))
    if any(action in z for z in used):
        raise Exception("That is an illeagal move.")

    boardcopy = copy.deepcopy(board)
    for i in range(3):
        for j in range(3):
            if (i, j) == action:
                turn = player(boardcopy)
                boardcopy[i][j] = turn
                return boardcopy


def winner(board):
    """
    Returns the winner of the game, if there is one.
    """
    boardcopy = copy.deepcopy(board)
    winCon = [(X, [X, X, X]), (O, [O, O, O])]
    rotatedBoard = np.transpose(boardcopy)
    for con in winCon:
        for i in boardcopy:
            if i == con[1]:
                return con[0]
        for i in rotatedBoard:
            if list(i) == con[1]:
                return con[0]
        if np.ndarray.tolist(np.diag(boardcopy)) == con[1] or np.ndarray.tolist(np.diag(np.fliplr(boardcopy))) == con[1]:
            return con[0]
    return None


def terminal(board):
    """
    Returns True if game is over, False otherwise.
    """
    if winner(board):
        return True
    elif not any(EMPTY in x for x in board):
        return True
    else:
        return False


def utility(board):
    """
    Returns 1 if X has won the game, -1 if O has won, 0 otherwise.
    """
    pwin = winner(board)
    if pwin == X:
        return 1
    elif pwin == O:
        return -1
    else:
        return 0


def minimax(board):
    """
    Returns the optimal action for the current player on the board.
    """
    turn = player(board)
    if turn == O:
        value, action = min_value(board)
        return action
    else:
        value, action = max_value(board)
        return action


def min_value(board):
    if terminal(board):
        return utility(board)
    v = 2
    move = ()

    for action in actions(board):
        check = max_value(result(board, action))

        if type(check) == int:
            diff = min(v, check)
            if v > diff:
                v = diff
                move = action
        else:
            diff = min(v, check[0])
            if v > diff:
                v = diff
                move = action

    return v, move


def max_value(board):
    if terminal(board):
        return utility(board)
    v = -2
    move = ()

    for action in actions(board):
        check = min_value(result(board, action))

        if type(check) == int:
            diff = max(v, check)
            if v < diff:
                v = diff
                move = action
        else:
            diff = max(v, check[0])
            if v < diff:
                v = diff
                move = action

    return v, move
